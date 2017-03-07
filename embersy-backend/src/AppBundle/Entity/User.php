<?php
namespace AppBundle\Entity;
 
use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;
use JMS\Serializer\Annotation\ExclusionPolicy;

/**
* @ORM\Entity(repositoryClass="AppBundle\EntityRepository\UserRepository")
* @ORM\Cache(usage="NONSTRICT_READ_WRITE", region="users_region")
* @ORM\Table(
*    name="users",
*    indexes={
*        @ORM\Index(name="facebook_id_index", columns={"facebook_id"}),
*        @ORM\Index(name="google_id_index", columns={"google_id"}),
*        @ORM\Index(name="twitter_id_index", columns={"twitter_id"}),
*        @ORM\Index(name="yahoo_id_index", columns={"yahoo_id"}),
*        @ORM\Index(name="slack_id_index", columns={"slack_id"})
*    }
*)
* @ExclusionPolicy("all")
*/
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(name="id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
 
    /**
     * @ORM\Column(name="facebook_id", type="string", nullable=true, options={"charset":"utf8" , "collation":"utf8_unicode_ci"}) 
    */
    protected $facebook_id;
 
    /**
     * @ORM\Column(name="facebook_access_token", type="string", nullable=true, options={"charset":"utf8" , "collation":"utf8_unicode_ci"}) 
    */
    protected $facebook_access_token;
 
    /**
     * @ORM\Column(name="google_id", type="string", nullable=true, options={"charset":"utf8" , "collation":"utf8_unicode_ci"}) 
    */
    protected $google_id;
 
    /**
     * @ORM\Column(name="google_access_token", type="string", nullable=true, options={"charset":"utf8" , "collation":"utf8_unicode_ci"}) 
    */
    protected $google_access_token;
 
    /**
     * @ORM\Column(name="twitter_id", type="string", nullable=true, options={"charset":"utf8" , "collation":"utf8_unicode_ci"}) 
    */
    protected $twitter_id;
 
    /**
     * @ORM\Column(name="twitter_access_token", type="string", nullable=true, options={"charset":"utf8" , "collation":"utf8_unicode_ci"}) 
    */
    protected $twitter_access_token;
 
    /**
     * @ORM\Column(name="yahoo_id", type="string", nullable=true, options={"charset":"utf8" , "collation":"utf8_unicode_ci"}) 
    */
    protected $yahoo_id;
 
    /**
     * @ORM\Column(name="yahoo_access_token", type="string", nullable=true, options={"charset":"utf8" , "collation":"utf8_unicode_ci"}) 
    */
    protected $yahoo_access_token;

    /**
     * @ORM\Column(name="slack_id", type="string", nullable=true, options={"charset":"utf8" , "collation":"utf8_unicode_ci"}) 
    */
    protected $slack_id;
 
    /**
     * @ORM\Column(name="slack_access_token", type="string", nullable=true, options={"charset":"utf8" , "collation":"utf8_unicode_ci"}) 
    */
    protected $slack_access_token;



    /**
     * Set facebookId
     *
     * @param string $facebookId
     *
     * @return User
     */
    public function setFacebookId($facebookId)
    {
        $this->facebook_id = $facebookId;

        return $this;
    }

    /**
     * Get facebookId
     *
     * @return string
     */
    public function getFacebookId()
    {
        return $this->facebook_id;
    }

    /**
     * Set facebookAccessToken
     *
     * @param string $facebookAccessToken
     *
     * @return User
     */
    public function setFacebookAccessToken($facebookAccessToken)
    {
        $this->facebook_access_token = $facebookAccessToken;

        return $this;
    }

    /**
     * Get facebookAccessToken
     *
     * @return string
     */
    public function getFacebookAccessToken()
    {
        return $this->facebook_access_token;
    }

    /**
     * Set googleId
     *
     * @param string $googleId
     *
     * @return User
     */
    public function setGoogleId($googleId)
    {
        $this->google_id = $googleId;

        return $this;
    }

    /**
     * Get googleId
     *
     * @return string
     */
    public function getGoogleId()
    {
        return $this->google_id;
    }

    /**
     * Set googleAccessToken
     *
     * @param string $googleAccessToken
     *
     * @return User
     */
    public function setGoogleAccessToken($googleAccessToken)
    {
        $this->google_access_token = $googleAccessToken;

        return $this;
    }

    /**
     * Get googleAccessToken
     *
     * @return string
     */
    public function getGoogleAccessToken()
    {
        return $this->google_access_token;
    }

    /**
     * Set twitterId
     *
     * @param string $twitterId
     *
     * @return User
     */
    public function setTwitterId($twitterId)
    {
        $this->twitter_id = $twitterId;

        return $this;
    }

    /**
     * Get twitterId
     *
     * @return string
     */
    public function getTwitterId()
    {
        return $this->twitter_id;
    }

    /**
     * Set twitterAccessToken
     *
     * @param string $twitterAccessToken
     *
     * @return User
     */
    public function setTwitterAccessToken($twitterAccessToken)
    {
        $this->twitter_access_token = $twitterAccessToken;

        return $this;
    }

    /**
     * Get twitterAccessToken
     *
     * @return string
     */
    public function getTwitterAccessToken()
    {
        return $this->twitter_access_token;
    }

    /**
     * Set yahooId
     *
     * @param string $yahooId
     *
     * @return User
     */
    public function setYahooId($yahooId)
    {
        $this->yahoo_id = $yahooId;

        return $this;
    }

    /**
     * Get yahooId
     *
     * @return string
     */
    public function getYahooId()
    {
        return $this->yahoo_id;
    }

    /**
     * Set yahooAccessToken
     *
     * @param string $yahooAccessToken
     *
     * @return User
     */
    public function setYahooAccessToken($yahooAccessToken)
    {
        $this->yahoo_access_token = $yahooAccessToken;

        return $this;
    }

    /**
     * Get yahooAccessToken
     *
     * @return string
     */
    public function getYahooAccessToken()
    {
        return $this->yahoo_access_token;
    }

    /**
     * Set slackId
     *
     * @param string $slackId
     *
     * @return User
     */
    public function setSlackId($slackId)
    {
        $this->slack_id = $slackId;

        return $this;
    }

    /**
     * Get slackId
     *
     * @return string
     */
    public function getSlackId()
    {
        return $this->slack_id;
    }

    /**
     * Set slackAccessToken
     *
     * @param string $slackAccessToken
     *
     * @return User
     */
    public function setSlackAccessToken($slackAccessToken)
    {
        $this->slack_access_token = $slackAccessToken;

        return $this;
    }

    /**
     * Get slackAccessToken
     *
     * @return string
     */
    public function getSlackAccessToken()
    {
        return $this->slack_access_token;
    }
}
