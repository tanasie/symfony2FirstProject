<?php

namespace Acme\ProductBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use Guzzle\Http\Client;
use Symfony\Component\HttpFoundation\Response;
use JMS\Serializer\SerializerBuilder;

class CustomerController extends FOSRestController
{
    /**
     */
    public function takeContentAction()
    {

        // create http client instance
        $client = new Client();

        // create a request
        $request = $client->get('http://svsjbshc1.stg.allegiantair.com:8580/otares/v2/api/lookups/CustomerRole');

        // send request / get response
        $response = $request->send();

        // this is the response body from the requested page (usually html)
        $result = $response->getBody(true);

        $results = json_decode($result,true);

        $serializer = SerializerBuilder::create()->build();

        $jsonContent = $serializer->serialize($results,'json');

        return new Response($jsonContent);

    }

}