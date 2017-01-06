<?php
/**
 * Created by PhpStorm.
 * User: Ulukut
 * Date: 6.12.2016
 * Time: 14:33
 *
 * @author Volkan Ulukut <arthan@gmail.com>
 */

namespace tests\Neo\NasaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Neo\NasaBundle\Document\Neo;

class DbTestCase extends WebTestCase
{
    private $dm;

    public function setUp()
    {
        $client = static::createClient();
        $this->dm = $client->getKernel()->getContainer()->get('doctrine_mongodb')->getManager();

        $neo = new Neo();
        $neo->setDate(date("Y-m-d"));
        $neo->setName("test name");
        $neo->setIsHazardous(true);
        $neo->setReference(1234567);
        $neo->setSpeed(5000);
        $this->dm->persist($neo);

        $neo = new Neo();
        $neo->setDate(date("Y-m-d"));
        $neo->setName("test name 2");
        $neo->setIsHazardous(false);
        $neo->setReference(2234567);
        $neo->setSpeed(6000);
        $this->dm->persist($neo);

        $this->dm->flush();
    }

    public function tearDown()
    {
        parent::tearDown();
        $collection = $this->dm->getDocumentCollection('NasaBundle:Neo'); // or just a class name
        $collection->drop();
        $this->dm->close();
        $this->dm = null; // avoid memory leaks
    }

}