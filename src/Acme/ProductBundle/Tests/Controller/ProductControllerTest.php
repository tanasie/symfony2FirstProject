<?php

namespace Acme\ProductBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ProductControllerTest extends WebTestCase
{
//database was cleared,new collections needed in order to apply this tests

    public function testAddProduct()
    {
        $client = static::createClient();

        // goes to the secure page
        $crawler = $client->request('GET', '/mongo/products/create.json');

        $this->assertCount(1, $crawler->filter('html:contains("lorem ipsum dolor sit amet")'));

    }


    public function testGetProduct()
    {
        $client = static::createClient();

        $crawler = $client->request('GET','/apiRestProduct/v2/products/1/by/id.json');

        $this->assertCount(1,$crawler->filter('html:contains("1.00")'));

    }

    public function testGetProductByName()
    {
        $client = static::createClient();

        $crawler = $client->request('POST','/mongo/products/product1/bies/names.json');

        $crawler = $client->followRedirect();

        //$this->assertTrue(strpos($crawler->text(),'555b04cc8ead0eb4000041a8') != false);
    }

}
