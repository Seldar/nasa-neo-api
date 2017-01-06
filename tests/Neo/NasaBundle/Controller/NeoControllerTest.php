<?php

namespace Tests\Neo\NasaBundle\Controller;

use Neo\NasaBundle\Controller\NeoController;

class NeoControllerTest extends DbTestCase
{
    public function testListHazardous()
    {
        $client = static::createClient();

        $client->request('GET', '/neo/hazardous');

        $this->assertEquals(
            [
                'reference' => 1234567,
                'name' => 'test name',
                'date' => date("Y-m-d"),
                'speed' => 5000,
                'is_hazardous' => true
            ],
            json_decode($client->getResponse()->getContent(), 1)[0]
        );
    }

    public function testGetFastest()
    {
        $client = static::createClient();

        $client->request('GET', '/neo/fastest');

        $this->assertEquals(
            [
                'reference' => 2234567,
                'name' => 'test name 2',
                'date' => date("Y-m-d"),
                'speed' => 6000,
                'is_hazardous' => false
            ],
            json_decode($client->getResponse()->getContent(), 1)
        );
    }

    public function testMockListHazardous()
    {
        $neoRepository = $this
            ->getMockBuilder('\Neo\NasaBundle\Repository\NeoRepository')
            ->disableOriginalConstructor()
            ->getMock();
        $neoRepository->expects($this->once())
            ->method('getHazardousNeo')
            ->will($this->returnValue([[
                'reference' => 1234567,
                'name' => 'test name',
                'date' => date("Y-m-d"),
                'speed' => 5000,
                'is_hazardous' => true
            ]]));

        $neoController = new NeoController();
        $neoController->setRepository($neoRepository);
        $this->assertEquals(
            [
                'reference' => 1234567,
                'name' => 'test name',
                'date' => date("Y-m-d"),
                'speed' => 5000,
                'is_hazardous' => true
            ],
            json_decode($neoController->listHazardous()->getContent(), 1)[0]
        );
    }

    public function testMockGetFastest()
    {
        $neoRepository = $this
            ->getMockBuilder('\Neo\NasaBundle\Repository\NeoRepository')
            ->disableOriginalConstructor()
            ->getMock();
        $neoRepository->expects($this->once())
            ->method('getFastestNeo')
            ->will($this->returnValue([
                'reference' => 1234567,
                'name' => 'test name',
                'date' => date("Y-m-d"),
                'speed' => 5000,
                'is_hazardous' => true
            ]));

        $neoController = new NeoController();
        $neoController->setRepository($neoRepository);
        $this->assertEquals(
            [
                'reference' => 1234567,
                'name' => 'test name',
                'date' => date("Y-m-d"),
                'speed' => 5000,
                'is_hazardous' => true
            ],
            json_decode($neoController->getFastest()->getContent(), 1)
        );
    }
}