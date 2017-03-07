<?php

namespace AppBundle\EntityRepository;

use Doctrine\ORM\EntityRepository;

class ProfilesRepository extends EntityRepository
{
    public function queryAllProfiles()
    {
        return $this->findAll();
    }

    public function queryProfileById($user_id)
    {
        $user_id = (int)$user_id;
        return $this->find($user_id);
    }

}
