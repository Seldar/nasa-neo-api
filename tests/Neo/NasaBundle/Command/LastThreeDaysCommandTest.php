<?php
/**
 * Created by PhpStorm.
 * User: Ulukut
 * Date: 6.12.2016
 * Time: 11:49
 *
 * @author Volkan Ulukut <arthan@gmail.com>
 */

namespace Tests\Neo\NasaBundle\Command;

class LastThreeDaysCommandTest extends CommandTestCase
{

    public function tearDown()
    {
        parent::tearDown();
        $client = self::createClient();
        $collection = $client->getKernel()->getContainer()->get('doctrine_mongodb')->getManager()->getDocumentCollection('NasaBundle:Neo');
        $collection->drop();
    }

    public function testExecute()
    {
        $client = self::createClient();
        $output = $this->runCommand($client, "neo:last3days");

        $repo = $client->getKernel()->getContainer()->get('doctrine_mongodb')->getManager()->getRepository('NasaBundle:Neo');

        $neo = $repo->getFastestNeo();

        $this->assertContains('Persist Last 3 Days', $output);
        $this->assertRegExp('/NEO Count: \d+/', $output);
        $this->assertRegExp('/\s+/', $neo['name']);
    }
}
