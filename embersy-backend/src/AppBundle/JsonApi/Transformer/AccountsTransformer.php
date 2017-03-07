<?php

namespace AppBundle\JsonApi\Transformer;

use AppBundle\JsonApi\Accounts;
use League\Fractal\TransformerAbstract;
use JMS\Serializer\SerializerBuilder;

class AccountsTransformer extends TransformerAbstract
{
    /**
     * Turn this item object into a generic array
     *
     * @return array
     */
    public function transform(Accounts $accounts)
    {
        $serializer = SerializerBuilder::create()->build();
        $array = $serializer->toArray($accounts);
        return $array;
    }

}
