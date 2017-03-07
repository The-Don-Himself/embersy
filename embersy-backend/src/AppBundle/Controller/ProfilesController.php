<?php
namespace AppBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\HttpCacheBundle\Configuration\Tag;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

use AppBundle\JsonApi\Profiles;
use AppBundle\JsonApi\Transformer\ProfilesTransformer;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;

use League\Fractal\Manager;
use League\Fractal\Resource\Item;
use League\Fractal\Resource\Collection;
use League\Fractal\Serializer\JsonApiSerializer;

/**
 * @Route("/api")
 */
class ProfilesController extends FOSRestController
{
    /**
    * @ApiDoc(
    *  resource=true,
    *  description="Query for Profiles",
    * )
    *
    * @Route("/profiles", requirements={"_format" = "json"}, name="profiles_api")
    * @Cache(public=true , maxage="60" , smaxage="60")
    * @Method({"GET"})
    */
    public function profilesAction(Request $request)
    {
        $profiles = $this->getDoctrine()->getManager()
            ->getRepository('AppBundle:Profiles')
            ->queryAllProfiles();

        // Build Empty JSONAPI Response If No Profiles Were Found
        $data = array( 'data' => array() , 'meta' => array( 'count' => 0 ) );

        if(!$profiles) {
            return new JsonResponse($data);
        }
        
        $serializer = $this->get('jms_serializer');

        // Build JSONAPI Transformer Object
        $jsonApiObject = array();
        foreach($profiles as $profile){
            // Use JMS Serializer To Exclude Unwanted Fields & Proper Doctrine Entity Serialization
            $jsonApiObject[] = new Profiles($serializer->toArray($profile));
        }

        // Add meta to response to tell frontend the number of records returned
        $meta = array(
            'count' => count($profiles)
        );

        // Instance of Transformer Manager
        $manager = new Manager();
        $manager->setSerializer(new JsonApiSerializer());
        // Transformer To Collection Type since it's many profiles instead of item type
        $resource = new Collection($jsonApiObject, new ProfilesTransformer(), 'profiles');
        $array = $manager->createData($resource)->toArray();
        $array['meta'] = $meta;

        $response = new JsonResponse();
        $response->setEncodingOptions($response->getEncodingOptions() | JSON_PRETTY_PRINT);
        $response->setJson($serializer->serialize($array, 'json'));
        return $response;
    }

    /**
    * @ApiDoc(
    *  resource=true,
    *  description="Query a Profile by its unique id",
    * )
    *
    * @Route("/profiles/{profile_id}", requirements={"profile_id" = "\d+","_format" = "json"}, name="profile_api")
    * @Cache(public=true , maxage="15" , smaxage="86400")
    * @Method({"GET"})
    * @Tag(expression="'profile-' ~ profile_id")
    */
    public function profileAction(Request $request, $profile_id)
    {
        $em = $this->getDoctrine()->getManager();
        $profile = $em
            ->getRepository('AppBundle:Profiles')
            ->queryProfileById($profile_id);

        if(!$profile) {
            throw $this->createNotFoundException(
                'No profile found for id '.$profile_id
            );
        }

        $serializer = $this->get('jms_serializer');

        $jsonApiObject = new Profiles($serializer->toArray($profile));

        $manager = new Manager();
        $manager->setSerializer(new JsonApiSerializer());
        $resource = new Item($jsonApiObject, new ProfilesTransformer(), 'profiles');
        $array = $manager->createData($resource)->toArray();

        $response = new JsonResponse();
        $response->setJson($serializer->serialize($array, 'json'));
        if ($this->get('kernel')->getEnvironment() == 'dev') {
            $response->setEncodingOptions($response->getEncodingOptions() | JSON_PRETTY_PRINT);
        }
        return $response;
    }

}
