<?php

namespace Acme\CategoryBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CategoryControllerTest extends WebTestCase
{

    public function testAddCategory()
    {
        $client = static::createClient();

        // goes to the secure page
        $crawler = $client->request('GET', '/mongodb/v1/somes/datas/create.json');

        $this->assertCount(1, $crawler->filter('html:contains("lorem ipsum dolor sit amet")'));

    }


    public function testGetCategory()
    {
        $client = static::createClient();

        $crawler = $client->request('GET','mongodb/v1/categories/5555cb428ead0e73020041ae.json');

        $this->assertCount(1,$crawler->filter('html:contains("5555cb428ead0e73020041ae")'));

    }

}
