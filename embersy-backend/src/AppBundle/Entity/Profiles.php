<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\Type;

/**
* @ORM\Entity(repositoryClass="AppBundle\EntityRepository\ProfilesRepository")
* @ORM\Cache(usage="NONSTRICT_READ_WRITE", region="profiles_region")
* @ORM\Table(
*    name="profiles",
*    indexes={
*        @ORM\Index(name="profiles_joined_index", columns={"joined"}),
*        @ORM\Index(name="profiles_status_index", columns={"status"})
*    }
* )
* @ExclusionPolicy("all")
*/

class Profiles
{
    /**
    * @ORM\Id
    * @ORM\Column(type="integer")
    * @Type("integer")
    * @ORM\GeneratedValue(strategy="NONE")
    * @Expose
    */
    protected $id;
    /**
    * @ORM\Cache(usage="NONSTRICT_READ_WRITE", region="users_region")
    * @ORM\OneToOne(targetEntity="User")
    * @ORM\JoinColumn(name="user", referencedColumnName="id")
    * @Expose
    */
    protected $user;
    /**
    * @ORM\Column(type="datetime")
     * @Expose
     * @Type("DateTime")
     */
    protected $joined;
    /**
     * @ORM\Column(type="string" , nullable=true , length=191)
     * @Expose
     */
    protected $firstname = null;
    /**
     * @ORM\Column(type="string" , nullable=true , length=191)
     * @Expose
     */
    protected $lastname = null;
    /**
     * @ORM\Column(type="integer", name="avatar")
     * @Expose
     */
    protected $avatarversion = 1;
    /**
    * @ORM\Column(type="integer")
    * @Expose
    */
    protected $status = 0;

    public function __construct(){
        $this->joined = new \DateTime();
    }

    /**
     * Set id
     *
     * @param integer $id
     *
     * @return Profiles
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set joined
     *
     * @param \DateTime $joined
     *
     * @return Profiles
     */
    public function setJoined($joined)
    {
        $this->joined = $joined;

        return $this;
    }

    /**
     * Get joined
     *
     * @return \DateTime
     */
    public function getJoined()
    {
        return $this->joined;
    }

    /**
     * Set firstname
     *
     * @param string $firstname
     *
     * @return Profiles
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get firstname
     *
     * @return string
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set lastname
     *
     * @param string $lastname
     *
     * @return Profiles
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * Get lastname
     *
     * @return string
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Set avatarversion
     *
     * @param integer $avatarversion
     *
     * @return Profiles
     */
    public function setAvatarversion($avatarversion)
    {
        $this->avatarversion = $avatarversion;

        return $this;
    }

    /**
     * Get avatarversion
     *
     * @return integer
     */
    public function getAvatarversion()
    {
        return $this->avatarversion;
    }

    /**
     * Set status
     *
     * @param integer $status
     *
     * @return Profiles
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return integer
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return Profiles
     */
    public function setUser(\AppBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \AppBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }
}
