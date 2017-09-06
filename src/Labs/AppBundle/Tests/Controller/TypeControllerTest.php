<?php

namespace Labs\AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TypeControllerTest extends WebTestCase
{
    public function testGettypes()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/getTypes');
    }

}
