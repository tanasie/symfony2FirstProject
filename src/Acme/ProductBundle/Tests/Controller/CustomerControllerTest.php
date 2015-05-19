<?php

namespace Acme\ProductBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CustomerControllerTest extends WebTestCase
{

// Check if exist all permissions
    public function testTakeContent()
    {
        $client = static::createClient();

        // goes to the secure page
        $crawler = $client->request('GET', '/takeContent.html');

        $html = $crawler->html();
        for($i=1;$i<21;$i++)
        {
            $var = substr_count($html,2);
            $this->assertGreaterThan(2,$var );
        }

    }

}
