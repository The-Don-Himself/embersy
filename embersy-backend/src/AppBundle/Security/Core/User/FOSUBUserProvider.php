<?php
namespace AppBundle\Security\Core\User;
 
use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;
use HWI\Bundle\OAuthBundle\Security\Core\User\FOSUBUserProvider as BaseClass;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use FOS\UserBundle\Model\UserManagerInterface;

use Doctrine\ORM\EntityManager;
use AppBundle\Exception\RedirectException;

use JMS\DiExtraBundle\Annotation\Inject;
use JMS\DiExtraBundle\Annotation\InjectParams;
use JMS\DiExtraBundle\Annotation\Service;

/**
 * @Service("my_user_provider")
 */
class FOSUBUserProvider extends BaseClass
{
    protected $em;
    private $profileCreate;
    private $oauthServer;
    private $client_id;
    private $client_secret;
    protected $userManager;

    /**
     * @InjectParams({
     *     "em" = @Inject("doctrine.orm.entity_manager"),
     *     "profileCreate" = @Inject("profile.create"),
     *     "oauthServer" = @Inject("fos_oauth_server.server"),
     *     "client_id" = @Inject("%client_id%"),
     *     "client_secret" = @Inject("%client_secret%"),
     *     "userManager" = @Inject("fos_user.user_manager"),
     *     "properties" = @Inject("%social_login_accounts%")
     * })
     */
    public function __construct(EntityManager $em, $profileCreate, $oauthServer, $client_id, $client_secret, UserManagerInterface $userManager, Array $properties)
    {
        $this->em = $em;
        $this->profileCreate = $profileCreate;
        $this->oauthServer = $oauthServer;
        $this->client_id = $client_id;
        $this->client_secret = $client_secret;
        parent::__construct($userManager, $properties);
    }

    /**
     * {@inheritDoc}
     */
    public function connect(UserInterface $user, UserResponseInterface $response)
    {
        $property = $this->getProperty($response);
        $username = $response->getUsername();
 
        //on connect - get the access token and the user ID
        $service = $response->getResourceOwner()->getName();
 
        $setter = 'set'.ucfirst($service);
        $setter_id = $setter.'Id';
        $setter_token = $setter.'AccessToken';
 
        //we "disconnect" previously connected users
        if (null !== $previousUser = $this->userManager->findUserBy(array($property => $username))) {
            $previousUser->$setter_id(null);
            $previousUser->$setter_token(null);
            $this->userManager->updateUser($previousUser);
        }
 
        //we connect current user
        $user->$setter_id($username);
        $user->$setter_token($response->getAccessToken());
 
        $this->userManager->updateUser($user);
    }
 
    /**
     * {@inheritdoc}
     */
    public function loadUserByOAuthUserResponse(UserResponseInterface $response)
    {
        $em = $this->em;
        $userManager = $this->userManager;
        $oauthServer = $this->oauthServer;
		$clientId = $this->client_id;
		$clientSecret = $this->client_secret;

        $register_url = '/register';

        $email = $response->getEmail();
        $username = $response->getUsername();
        $firstname = $response->getFirstname();
        $lastname = $response->getLastname();
        $avatar = $response->getProfilePicture();

        $service = $response->getResourceOwner()->getName();

        if ($service == "slack") {
               $slack_user_id      = $response->getUsername();
               $slack_access_token = $response->getAccessToken();
               $user_info_url = 'https://slack.com/api/users.info';
               $url = "$user_info_url?token=$slack_access_token&user=$slack_user_id";

               $ch = curl_init();
               curl_setopt($ch, CURLOPT_URL, $url);
               curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
               curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
               curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
               curl_setopt($ch, CURLOPT_AUTOREFERER, true);
               curl_setopt($ch, CURLOPT_TIMEOUT, 15);
               curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
               $curl_result = curl_exec($ch);
               curl_close($ch);

               $json = json_decode($curl_result, true);
               $slack_user = $json['user'];
               $slack_profile = $slack_user['profile'];
               $email = $slack_profile['email'];
               $firstname = $slack_profile['first_name'];
               $lastname = $slack_profile['last_name'];
               $avatar = $slack_profile['image_192'];
        }

        $user = null;
        if($email) {
            $user = $userManager->findUserByEmail($email);
        }
        if (null === $user) {
            $user = $userManager->findUserBy(array($this->getProperty($response) => $username));
        }

        //when the user is registrating
        if (!$user) {
            if(!$email) {
                // 'Sorry, but '.$service.' did not return your email address which we need to authenticate you, please try another service or manually register - it takes less than 1 minute to do so.'
                throw new RedirectException(new RedirectResponse($register_url));
            }
            if(!$username) {
                //	'Sorry, but '.$service.' did not return your user ID which we need to authenticate you, please try another service or manually register - it takes less than 1 minute to do so.'
                throw new RedirectException(new RedirectResponse($register_url));
            }

            // I've Not Done It Here But You Should Add A Service Call Here To Check Username Sanity & Availablility First

            $setter = 'set'.ucfirst($service);
            $setter_id = $setter.'Id';
            $setter_token = $setter.'AccessToken';

            // create new user here
            $user = $userManager->createUser();

            $user->$setter_id($username);
            $user->$setter_token($response->getAccessToken());

            $user->setUsername($username);
            $user->setEmail($email);
            $user->setPlainPassword($email);
            $user->setEnabled(true);
            $userManager->updateUser($user);

            $user_id = $user->getId();

            // Create new profile
            // This service call returns the newly created object, you can store it in a variable if you want to do further processing
            $this->profileCreate->create($user_id, $firstname, $lastname);

            if ($avatar) {
                //Upload Avatar Somewhere
            }

			$grantRequest = new Request(array(
                'client_id'  => $clientId,
                'client_secret' => $clientSecret,
                'grant_type' => 'password',
                'username' => $username,
                'password' => $email
            ));

			$tokenResponse = $oauthServer->grantAccessToken($grantRequest);

			$token = $tokenResponse->getContent();

            throw new RedirectException(new RedirectResponse('/social-login?service='. $service .'&oauth2=' . urlencode($token)));
        }

        $user_id = $user->getId();
        $username = $user->getUsername();

        $old_password = $user->getPassword();
        $old_salt = $user->getSalt();

        $user->setPlainPassword('password');

        $userManager->updateUser($user);

        //if user exists - just update access token
        $serviceName = $response->getResourceOwner()->getName();
        $setter = 'set' . ucfirst($serviceName) . 'AccessToken';
        $user->$setter($response->getAccessToken());

        $grantRequest = new Request(array(
            'client_id'  => $clientId,
            'client_secret' => $clientSecret,
            'grant_type' => 'password',
            'username' => $username,
            'password' => 'password'
        ));

        $tokenResponse = $oauthServer->grantAccessToken($grantRequest);
        $token = $tokenResponse->getContent();

        $user = $em
            ->getRepository('AppBundle:User')
            ->queryUserById($user_id);

        $user->setPassword($old_password);
        $user->setSalt($old_salt);

        $em->flush();

        throw new RedirectException(new RedirectResponse('/social-login?service='. $service .'&oauth2=' . urlencode($token)));
    }

}
