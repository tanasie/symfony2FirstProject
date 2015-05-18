<?php

namespace Acme\ProductBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ProductControllerTest extends WebTestCase
{

    public function testAddProduct()
    {
        $client = static::createClient();

        // goes to the secure page
        $crawler = $client->request('GET', '/apiRestProduct/v2/products/create.json');

        $this->assertCount(1, $crawler->filter('html:contains("lorem ipsum dolor sit amet")'));

    }


    public function testGetProduct()
    {
        $client = static::createClient();

        $crawler = $client->request('GET','/apiRestProduct/v2/products/1/by/id.json');

        $this->assertCount(1,$crawler->filter('html:contains("1.00")'));

    }

}
