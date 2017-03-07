<?php

namespace AppBundle\Services;

use JMS\DiExtraBundle\Annotation\Inject;
use JMS\DiExtraBundle\Annotation\InjectParams;
use JMS\DiExtraBundle\Annotation\Service;

/**
 * @Service("user.create")
 */
class UserCreate
{
    protected $userManager;

    /**
     * @InjectParams({
     *     "userManager" = @Inject("fos_user.user_manager")
     * })
     */
    public function __construct($userManager)
    {
        $this->userManager = $userManager;
    }

    public function create($username, $email, $password)
    {
        $userManager = $this->userManager;
        $user = $userManager->createUser();
        $user->setUsername($username);
        $user->setEmail($email);
        $user->setPlainPassword($password);
        $user->setEnabled(true);
        $userManager->updateUser($user);
        return $user;
    }

}
