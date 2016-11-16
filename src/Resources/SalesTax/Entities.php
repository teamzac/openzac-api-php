<?php

namespace TeamZac\OpenZac\Resources\SalesTax;

use Carbon\Carbon;
use TeamZac\OpenZac\AbstractClient;

class Entities extends AbstractClient
{
    protected $resourcePath = 'sales-tax/entities';

    /**
     * Get the collections for a given entity, pagination availale
     *
     * @param   string $slug
     * @param   array $params
     * @return  Object
     */
    public function find($slug, $params=[])
    {
        $params = array_merge(
            $params,
            [
            ]
        );
        return $this->get($slug, $params);
    }
}