<?php
/**
 * Created by PhpStorm.
 * User: Ulukut
 * Date: 2.12.2016
 * Time: 16:17
 *
 * @author Volkan Ulukut <arthan@gmail.com>
 */

namespace Neo\NasaBundle\Service;

use \GuzzleHttp\Client;

/**
 * Class NasaAPI
 *
 * API Bridge to connect and retrieve data from nasa API.
 *
 * @package Neo\NasaBundle\Service
 */
class NasaAPI
{
    /**
     * Base url of the API
     *
     * @var string
     */
    const BASE_URL = 'https://api.nasa.gov/';
    /**
     * API key to use
     *
     * @var string
     */
    const API_KEY = 'N7LkblDsc5aen05FJqBQ8wU4qSdmsftwJagVK7UD';

    /**
     * Call the api with given parameters
     *
     * @param string $method
     * @param array $params
     *
     * @return \Psr\Http\Message\StreamInterface
     */
    private function call($method, $params)
    {
        $client = new Client(['base_uri' => self::BASE_URL]);
        $params['api_key'] = self::API_KEY;
        $response = $client->request('GET', $method, [
            'query' => $params
        ]);
        return $response->getBody();
    }

    /**
     * Retrieves Neo from nasa API by date interval
     *
     * @param string $start_date
     * @param string $end_date
     *
     * @return array|null
     */
    public function getNEOByDate($start_date, $end_date)
    {
        return json_decode($this->call('neo/rest/v1/feed', ['start_date' => $start_date, 'end_date' => $end_date]));
    }
}