<?php

namespace App\Services\JokeService;

use GuzzleHttp\Client;

class JokeService implements JokeServiceInterface
{
    protected $baseUrl = 'http://api.icndb.com';
    protected $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => $this->baseUrl,
            'timeout'  => 10,
        ]);
    }

    /**
     * Call API
     *
     * @param $url
     * @param array $options
     * @return mixed|\Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    protected function callApi($url, $options=[])
    {
        return $this->client->request('GET', $url, $options);
    }

    /**
     * Get categories from API service
     *
     * @return array
     * @throws ApiUnavailableException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getCategories()
    {
        try {

            $response = $this->callApi('/categories');
            $responseObj = json_decode((string) $response->getBody(), true);

            $categories = [];
            foreach ($responseObj['value'] as $category) {
                $categories[$category] = $category;
            }

            return $categories;

        } catch (\Exception $e){
            throw new ApiUnavailableException();
        }
    }

    /**
     * Get random joke from API service
     *
     * @param string $category
     * @return array
     * @throws ApiUnavailableException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getRandomJoke(string $category)
    {
        try {
            $response = $this->callApi('/jokes/random', [
                'query' => ['limitTo' => '[' . $category . ']']
            ]);
            $responseObj = json_decode((string) $response->getBody(), true);

            return [
                'id' => $responseObj['value']['id'],
                'text' => $responseObj['value']['joke'],
                'categories' => $responseObj['value']['categories'],
            ];
        } catch (\Exception $e){
            throw new ApiUnavailableException();
        }
    }
}