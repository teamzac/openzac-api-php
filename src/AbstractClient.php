<?php

namespace TeamZac\OpenZac;

use GuzzleHttp\Client as GuzzleClient;
use TeamZac\OpenZac\Support\Resource;
use TeamZac\OpenZac\Support\ResourceCollection;

class AbstractClient
{
    protected $baseUrl = 'https://openzac.com/api';

    protected $resourcePath = '';

    protected $apiToken;

    protected $guzzle;

    /**
     * Public constructor
     *
     * @param   
     * @return  
     */
    public function __construct($token)
    {
        $this->apiToken = $token;

        $this->guzzle = new GuzzleClient([
            'base_uri' => $this->baseUrl,
            'defaults' => [
                'headers' => ['Authorization' => 'Bearer ' . $this->apiToken]
            ]
        ]);
    }

    /**
     * Perform a GET request
     *
     * @param   
     * @return  
     */
    public function get($path, $params=[], $headers=[])
    {
        $uri = $this->createUriFromPath($path);

        $headers = array_merge($headers, $this->defaultHeaders());
        $response = $this->guzzle->get($uri, [
            'query' => $params,
            'headers' => $headers,
            'debug' => false
        ]);

        return $this->parseResponse($response);
    }

    /**
     * 
     * 
     * @param   
     * @return  
     */
    protected function parseResponse($response)
    {
        $json = json_decode( $response->getBody()->__toString() );
        
        if ( isset($json->data) && is_array($json->data) )
        {
            return new ResourceCollection($json);
        }

        return new Resource($json);
    }

    /**
     * Create the URI
     * 
     * @param   $path
     * @return  string
     */
    public function createUriFromPath($path)
    {
        $path = trim($path, '/');

        $components = [
            '/api',
            $this->resourcePath,
            $path
        ];

        return str_replace('//', '/', implode('/', $components));
    }

    /**
     * 
     *
     * @param   
     * @return  
     */
    protected function defaultHeaders()
    {
        return [
            'Authorization' => 'Bearer '.$this->apiToken
        ];
    }

    /**
     * Get the API token
     * 
     * @return  string
     */
    public function getApiToken()
    {
        return $this->apiToken;
    }
}