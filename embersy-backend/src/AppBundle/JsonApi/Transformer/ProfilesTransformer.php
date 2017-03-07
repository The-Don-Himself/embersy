<?php

namespace AppBundle\JsonApi\Transformer;

use AppBundle\JsonApi\Profiles;
use AppBundle\JsonApi\Transformer\UserTransformer;
use League\Fractal\TransformerAbstract;
use JMS\Serializer\SerializerBuilder;

class ProfilesTransformer extends TransformerAbstract
{
    /**
     * List of resources to automatically include
     *
     * @var array
     */
    protected $defaultIncludes = [
        'user'
    ];

    /**
     * Turn this item object into a generic array
     *
     * @return array
     */
    public function transform(Profiles $profiles)
    {
        $serializer = SerializerBuilder::create()->build();
        $array = $serializer->toArray($profiles);

        unset($array['user']);

        return $array;
    }

    /**
     * Include User
     *
     * @return League\Fractal\ItemResource
     */
    public function includeUser(Profiles $profiles)
    {
        $user = $profiles->user;
        return $user ? $this->item($user, new UserTransformer, 'users') : null;
    }

}
