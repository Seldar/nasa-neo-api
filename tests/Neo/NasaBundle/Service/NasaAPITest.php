<?php
/**
 * Created by PhpStorm.
 * User: Ulukut
 * Date: 6.12.2016
 * Time: 15:44
 *
 * @author Volkan Ulukut <arthan@gmail.com>
 */

namespace Tests\Neo\NasaBundle\Service;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use \GuzzleHttp\Client;

class NasaAPITest extends WebTestCase
{
    public function testAPI()
    {
        $client = static::createClient();
        $api = $client->getContainer()->get('nasa.api');

        $client = new Client(['base_uri' => $api::BASE_URL]);
        $params['api_key'] = $api::API_KEY;
        $params['start_date'] = '2016-12-04';
        $params['end_date'] = '2016-12-05';
        $response = $client->request('GET', "neo/rest/v1/feed/", [
            'query' => $params
        ]);

        $this->assertEquals(
            200,
            $response->getStatusCode()
        );

    }

    public function testGetNeoByDate()
    {
        $client = static::createClient();
        $api = $client->getContainer()->get('nasa.api');
        $result = $api->getNEOByDate("2016-12-04", "2016-12-05");

        $this->assertGreaterThan(0, count($result));
    }
}
