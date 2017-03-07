<?php
namespace AppBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;

class CorsController extends FOSRestController
{
    /**
    * @ApiDoc(
    *  resource=true,
    *  description="Accept CORS requests",
    * )
    *
    * @Route("{cors}", requirements={"cors" = ".+","_format" = "json"}, name="cors")
    * @Method({"OPTIONS"})
    * @Cache(public=true , maxage="86400" , smaxage="86400")
    */
    public function corsAction(Request $request)
    {
        $response = new JsonResponse();
        $response->headers->set('Access-Control-Allow-Origin', '*');
        $response->headers->set('Access-Control-Allow-Credentials', 'true');
        $response->headers->set('Access-Control-Allow-Headers', 'Access-Control-Allow-Origin,Accept,Authorization,X-Requested-With,Content-Type,Access-Control-Request-Method,Access-Control-Request-Headers');
        return $response;
    }
}
