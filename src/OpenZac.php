<?php

namespace TeamZac\OpenZac;

use GuzzleHttp\Client as GuzzleClient;

class OpenZac extends AbstractClient
{

    /**
     * Catch calls to methods matching a resource and return the resource helper
     *
     * @param   
     * @return  
     */
    public function __get($key)
    {
        if ( collect(['entities', 'salesTax', 'hotelTax', 'beverageTax'])->contains($key) )
        {
            $class = 'TeamZac\OpenZac\Resources\\'.ucwords($key);
            return new $class($this->apiToken);
        }
    }
}