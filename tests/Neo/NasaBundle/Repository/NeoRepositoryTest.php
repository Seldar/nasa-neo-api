<?php
/**
 * Created by PhpStorm.
 * User: Ulukut
 * Date: 6.12.2016
 * Time: 14:30
 *
 * @author Volkan Ulukut <arthan@gmail.com>
 */

namespace Tests\Neo\NasaBundle\Repository;

use Tests\Neo\NasaBundle\Controller\DbTestCase;

class NeoRepositoryTest extends DbTestCase
{
    public function testSave()
    {
        $client = self::createClient();
        $manager = $client->getKernel()->getContainer()->get('doctrine_mongodb')->getManager();
        $repository = $manager->getRepository('NasaBundle:Neo');
        $neo = new \stdClass;
        $neo->name = "repo test";
        $neo->date = date("Y-m-d");
        $neo->neo_reference_id = 98764542;
        $neo->is_potentially_hazardous_asteroid = false;
        $speed = new \stdClass;
        $speed->kilometers_per_hour = 5857323;
        $rel_velocity = new \stdClass;
        $rel_velocity->relative_velocity = $speed;
        $neo->close_approach_data[0] = $rel_velocity;

        $repository->save(date("Y-m-d"), $neo);
        $manager->flush();

        $result = $repository
            ->findOneBy(["reference" => 98764542])
            ->toArray();

        $this->assertSame(
            [
                'reference' => 98764542,
                'name' => 'repo test',
                'date' => date("Y-m-d"),
                'speed' => 5857323,
                'is_hazardous' => false,
            ], $result);

    }

    public function testSaveAll()
    {
        $client = self::createClient();
        $manager = $client->getKernel()->getContainer()->get('doctrine_mongodb')->getManager();
        $repository = $manager->getRepository('NasaBundle:Neo');
        $neo = new \stdClass;
        $neo->name = "repo test";
        $neo->date = date("Y-m-d");
        $neo->neo_reference_id = 98764542;
        $neo->is_potentially_hazardous_asteroid = false;
        $speed = new \stdClass;
        $speed->kilometers_per_hour = 5857323;
        $rel_velocity = new \stdClass;
        $rel_velocity->relative_velocity = $speed;
        $neo->close_approach_data[0] = $rel_velocity;

        $repository->saveAll(date("Y-m-d"), [$neo, $neo]);

        $result = $repository
            ->findBy(["reference" => 98764542]);


        $this->assertSame(
            [
                [
                    'reference' => 98764542,
                    'name' => 'repo test',
                    'date' => date("Y-m-d"),
                    'speed' => 5857323,
                    'is_hazardous' => false,
                ],
                [
                    'reference' => 98764542,
                    'name' => 'repo test',
                    'date' => date("Y-m-d"),
                    'speed' => 5857323,
                    'is_hazardous' => false,
                ]
            ], [$result[0]->toArray(), $result[1]->toArray()]);
    }

    public function testGetHazardousNeo()
    {
        $client = self::createClient();
        $manager = $client->getKernel()->getContainer()->get('doctrine_mongodb')->getManager();
        $repository = $manager->getRepository('NasaBundle:Neo');

        $result = $repository->getHazardousNeo();

        $this->assertSame(
            [
                'reference' => 1234567,
                'name' => 'test name',
                'date' => date("Y-m-d"),
                'speed' => '5000',
                'is_hazardous' => true
            ], $result[0]);
    }

    public function testGetFastestNeo()
    {
        $client = self::createClient();
        $manager = $client->getKernel()->getContainer()->get('doctrine_mongodb')->getManager();
        $repository = $manager->getRepository('NasaBundle:Neo');

        $result = $repository->getFastestNeo();

        $this->assertSame(
            [
                'reference' => 2234567,
                'name' => 'test name 2',
                'date' => date("Y-m-d"),
                'speed' => '6000',
                'is_hazardous' => false
            ], $result);
    }
}
