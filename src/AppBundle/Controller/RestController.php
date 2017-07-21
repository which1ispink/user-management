<?php
namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class RestController
 *
 * Contains methods common between the RESTful controllers
 */
class RestController extends Controller
{
    /**
     * Returns an instance of JsonResponse with the JSON serialized data pretty-printed
     *
     * @param mixed $data
     * @param int $statusCode
     * @return JsonResponse
     */
    protected function jsonSerializeResponse($data, $statusCode = 200)
    {
        $response = new JsonResponse($data, $statusCode);
        $response->setEncodingOptions( $response->getEncodingOptions() | JSON_PRETTY_PRINT );
        return $response;
    }
}
