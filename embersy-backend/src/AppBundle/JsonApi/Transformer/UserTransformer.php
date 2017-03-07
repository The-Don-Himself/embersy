<?php

namespace AppBundle\JsonApi\Transformer;

use AppBundle\JsonApi\User;
use League\Fractal\TransformerAbstract;
use JMS\Serializer\SerializerBuilder;

class UserTransformer extends TransformerAbstract
{
    /**
     * @return array
     */
    public function transform(User $user)
    {
        $serializer = SerializerBuilder::create()->build();
        return $serializer->toArray($user);
    }

}
