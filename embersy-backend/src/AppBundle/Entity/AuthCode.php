<?php

namespace AppBundle\Entity;

use FOS\OAuthServerBundle\Entity\AuthCode as BaseAuthCode;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="oauth2_auth_codes")
 * @ORM\Entity
 * @ORM\Cache(usage="NONSTRICT_READ_WRITE", region="auth_code_region")
 * @ORM\AttributeOverrides({
 *  @ORM\AttributeOverride(
 *    name="token",
 *    column=@ORM\Column(
 *      name="token",
 *      type="string",
 *      length=191
 *    )
 *  ),
 *  @ORM\AttributeOverride(
 *    name="scope",
 *    column=@ORM\Column(
 *      name="scope",
 *      type="string",
 *      nullable=true,
 *      length=191
 *    )
 *  )
 * })
 */
class AuthCode extends BaseAuthCode
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Client")
     * @ORM\JoinColumn(nullable=false)
     * @ORM\Cache(usage="NONSTRICT_READ_WRITE", region="client_region")
     */
    protected $client;

    /**
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\Cache(usage="NONSTRICT_READ_WRITE", region="users_region")
     */
    protected $user;
}
