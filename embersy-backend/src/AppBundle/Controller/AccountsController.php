<?php

namespace AppBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;

use League\Fractal\Manager;
use League\Fractal\Resource\Item;
use League\Fractal\Serializer\JsonApiSerializer;

use AppBundle\JsonApi\Accounts;
use AppBundle\JsonApi\Transformer\AccountsTransformer;

/**
 * @Route("/api/accounts")
 */
class AccountsController extends FOSRestController
{
    /**
    * @ApiDoc(
    *  resource=true,
    *  description="Get current account for logged in user",
    * )
    *
    * @Security("is_authenticated(true)")
    * @Route("/me", name="accounts_me")
    * @Method({"GET"})
    * @Cache(public=false , maxage="0" , smaxage="0")
    */
    public function meAction(Request $request)
    {
        $user = $this->getUser();
        $user_id = $user->getId();

        $em = $this->getDoctrine()->getManager();
        $profile = $em
            ->getRepository('AppBundle:Profiles')
            ->queryProfileById($user_id);

        $serializer = $this->get('jms_serializer');
        $profile_array = $serializer->toArray($profile);

        $jsonApiObject = new Accounts($profile_array);

        $manager = new Manager();
        $manager->setSerializer(new JsonApiSerializer());
        $resource = new Item($jsonApiObject, new AccountsTransformer(), 'accounts');
        $array = $manager->createData($resource)->toArray();

        $response = new JsonResponse();
        $response->setJson($serializer->serialize($array, 'json'));
        if ($this->get('kernel')->getEnvironment() == 'dev') {
            $response->setEncodingOptions($response->getEncodingOptions() | JSON_PRETTY_PRINT);
        }
        return $response;
    }

    /**
    * @ApiDoc(
    *  resource=true,
    *  description="Create A New User Account",
    * )
    *
    * @Route("", name="account_new")
    * @Method({"POST"})
    * @Cache(public=false , maxage="0" , smaxage="0")
    */
    public function newAction(Request $request)
    {
        $username = strip_tags($request->get('username'));
        $username = str_replace(' ', '_', $username);
        $email = strip_tags($request->get('email'));
        $password = $request->get('password');
        $firstname = strip_tags($request->get('firstname'));
        $lastname = strip_tags($request->get('lastname'));

        $view = View::create();

        if (!$username || !$email || !$password || !$firstname || !$lastname) {
            $view->setStatusCode(Response::HTTP_BAD_REQUEST);
            return $view;
        }

        // This service call returns the newly user
        $user = $this->get('user.create')->create($username, $email, $password);
        $user_id = $user->getId();

        // This service call returns the newly created object, you can store it in a variable if you want to do further processing
        $this->get('profile.create')->create($user_id, $firstname, $lastname);

        $data['user_id'] = $user_id;
        $view->setData($data);
        $view->setStatusCode(Response::HTTP_CREATED);
        return $view;
    }

    /**
    * @ApiDoc(
    *  resource=true,
    *  description="Edit a Profile",
    * )
    *
    * @Security("is_authenticated(true)")
    * @Route("/edit", name="account_edit")
    * @Method({"POST"})
    */
    public function editAction(Request $request)
    {
        $username = strip_tags($request->get('username'));
        $username = str_replace(' ', '_', $username);
        $email = strip_tags($request->get('email'));
        $firstname = strip_tags($request->get('firstname'));
        $lastname = strip_tags($request->get('lastname'));

        $view = View::create();

        if (!$username || !$email || !$firstname || !$lastname) {
            $view->setStatusCode(Response::HTTP_BAD_REQUEST);
            return $view;
        }

        // Check Username etc then Call the User Manager & Update User

        $view->setStatusCode(Response::HTTP_OK);
        return $view;
    }

}
