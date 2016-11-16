<?php

namespace TeamZac\OpenZac\Resources;

use Carbon\Carbon;
use TeamZac\OpenZac\AbstractClient;

class SalesTax extends AbstractClient
{
    protected $resourcePath = 'sales-tax';

    /**
     * Get the collection report for a given period, pagination availale
     *
     * @param   Carbon $month
     * @param   array $params
     * @return  Object
     */
    public function collectionsForMonth(Carbon $month, $params=[])
    {
        $params = array_merge(
            $params,
            [
            ]
        );
        $path = sprintf("collections/%s", $month->format('Y/m'));
        return $this->get($path, $params);
    }

    /**
     * Get the collection report for a given period, pagination availale
     *
     * @param   Carbon $month
     * @param   array $params
     * @return  Object
     */
    public function collectionsForEntity(Carbon $month, $params=[])
    {
        $params = array_merge(
            $params,
            [
            ]
        );
        $path = sprintf("collections/%s", $month->format('Y/m'));
        return $this->get($path, $params);
    }

    /**
     * Get the collection report for a given period, pagination availale
     *
     * @param   Carbon $month
     * @param   array $params
     * @return  Object
     */
    public function collectionsForEntityInMonth(Carbon $month, $params=[])
    {
        $params = array_merge(
            $params,
            [
            ]
        );
        $path = sprintf("collections/%s", $month->format('Y/m'));
        return $this->get($path, $params);
    }

    /**
     * Catch calls to methods matching a resource and return the resource helper
     *
     * @param   
     * @return  
     */
    public function __get($key)
    {
        if ( collect(['collections', 'entities'])->contains($key) )
        {
            $class = 'TeamZac\OpenZac\Resources\SalesTax\\'.ucwords($key);
            return new $class($this->apiToken);
        }
    }
}