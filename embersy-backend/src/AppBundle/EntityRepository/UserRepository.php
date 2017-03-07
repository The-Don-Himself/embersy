<?php
namespace AppBundle\EntityRepository;
 
use Doctrine\ORM\EntityRepository;

class UserRepository extends EntityRepository
{
    public function queryAllUsers()
    {
        return $this->findAll();
    }

    public function queryUserById($user_id)
    {
        $user_id = (int)$user_id;
        return $this->find($user_id);
    }

    public function queryUserByUsername($username)
    {
        return $this->findOneByUsername($username);
    }

    public function queryUserBySlackUserId($slack_user_id)
    {
        return $this->findOneBySlackId($slack_user_id);
    }

    public function queryUserByEmail($email)
    {
        return $this->findOneByEmail($email);
    }
}
