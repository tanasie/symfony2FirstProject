<?php

namespace Acme\StoreBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ProductControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/mongo/hello/Fabien');

        $this->assertTrue($crawler->filter('html:contains("Hello Fabien")')->count() > 0);
    }

    /**
     * Test show product
     */
    public function testShowProduct()
    {
        $client = static::createClient();

        $crawler = $client->request('GET','/mongo/showProduct/5551f9cd49ee1268020041ae');

        $this->assertTrue($crawler->filter('html:contains("123")')->count() > 0 );
    }

    public function testShowAllProductsByName()
    {

        $client = static::createClient();

        $crawler = $client->request('GET','/mongo/showProducts/a');
        $this->assertCount(3, $crawler->filter('li'));
    }


    public function testAddProduct()
    {
        $client = static::createClient();

        // goes to the secure page
        $crawler = $client->request('GET', '/mongo/createProduct');

        // submits the login form
        $form = $crawler->selectButton('product[save]')->form(array('product[name]' => 'unit test product', 'product[price]' => '888'));
        $client->submit($form);

        // redirect to the original page (but now authenticated)
        $crawler = $client->followRedirect();
        // check that the page is the right one
        $this->assertCount(1, $crawler->filter('html:contains("unit test product")'));

    }
}
