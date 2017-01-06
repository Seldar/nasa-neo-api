<?php

namespace Tests\Neo\NasaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $client->request('GET', '/');

        $this->assertContains('{"hello":"world!"}', $client->getResponse()->getContent());
    }
}
