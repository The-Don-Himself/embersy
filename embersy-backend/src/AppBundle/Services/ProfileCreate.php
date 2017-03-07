<?php

namespace AppBundle\Services;

use DateTime;
use Doctrine\ORM\EntityManager;
use AppBundle\Entity\Profiles;

use JMS\DiExtraBundle\Annotation\Inject;
use JMS\DiExtraBundle\Annotation\InjectParams;
use JMS\DiExtraBundle\Annotation\Service;

/**
 * @Service("profile.create")
 */
class ProfileCreate
{
    protected $em;

    /**
     * @InjectParams({
     *     "em" = @Inject("doctrine.orm.entity_manager")
     * })
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function create($user_id, $firstname = null, $lastname = null)
    {
        $em = $this->em;

        $profile = new Profiles();

        $user_reference = $em->getReference('AppBundle\Entity\User', $user_id);

        $profile->setId($user_id);
        $profile->setUser($user_reference);
        $profile->setJoined(new DateTime());
        $profile->setFirstname($firstname);
        $profile->setLastname($lastname);
        $profile->setStatus(0);

        $em->persist($profile);
        $em->flush();

        return $profile;

    }

}
