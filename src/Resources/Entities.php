<?php

namespace TeamZac\OpenZac\Resources;

use TeamZac\OpenZac\AbstractClient;

class Entities extends AbstractClient
{
    protected $resourcePath = 'entities';

    /**
     * Get all entities
     *
     * @param   
     * @return  
     */
    public function all($params=[])
    {
        $params = array_merge(
            $params,
            [
            ]
        );
        return $this->get('', $params);
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