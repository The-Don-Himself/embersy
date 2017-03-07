<?php

namespace AppBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\HttpCacheBundle\Configuration\Tag;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

use AppBundle\JsonApi\User;
use AppBundle\JsonApi\Transformer\UserTransformer;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;

use League\Fractal\Manager;
use League\Fractal\Resource\Item;
use League\Fractal\Serializer\JsonApiSerializer;

/**
 * @Route("/api")
 */
class UsersController extends FOSRestController
{
    /**
    * @ApiDoc(
    *  resource=true,
    *  description="Query a User by its unique id",
    * )
    *
    * @Route("/users/{user_id}", requirements={"user_id" = "\d+","_format" = "json"}, name="user_api")
    * @Method({"GET"})
    * @Cache(public=true , maxage="15" , smaxage="86400")
    * @Tag(expression="'user-' ~ user_id")
    */
    public function userAction(Request $request, $user_id)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $em
            ->getRepository('AppBundle:User')
            ->queryUserById($user_id);

        if(!$user) {
            throw $this->createNotFoundException();
        }

        $serializer = $this->get('jms_serializer');
        $user_array = $serializer->toArray($user);

        $jsonApiObject = new User($user_array);

        $manager = new Manager();
        $manager->setSerializer(new JsonApiSerializer());
        $resource = new Item($jsonApiObject, new UserTransformer(), 'users');
        $array = $manager->createData($resource)->toArray();

        $response = new JsonResponse();
        $response->setJson($serializer->serialize($array, 'json'));
        $response->setEncodingOptions($response->getEncodingOptions() | JSON_PRETTY_PRINT);
        return $response;
    }

}
