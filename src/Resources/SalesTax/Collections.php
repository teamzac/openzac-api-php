<?php

namespace TeamZac\OpenZac\Resources\SalesTax;

use Carbon\Carbon;
use TeamZac\OpenZac\AbstractClient;

class Collections extends AbstractClient
{
    protected $resourcePath = 'sales-tax/collections';

    /**
     * Get the collection report for a given period, pagination availale
     *
     * @param   Carbon $month
     * @param   array $params
     * @return  Object
     */
    public function forMonth(Carbon $month, $params=[])
    {
        $params = array_merge(
            $params,
            [
            ]
        );
        return $this->get($month->format('Y/m'), $params);
    }

    /**
     * Find a specific entity
     *
     * @param   
     * @return  
     */
    public function find($slug)
    {
        return $this->get($slug);
    }
}