<?php

namespace TeamZac\OpenZac\Support;

class QueryBuilder
{
    protected $wheres = [];

    /**
     * 
     * 
     * @param   string $key
     * @param   mixed $value
     * @return  
     */
    public function where($key, $value)
    {
        $this->wheres[$key] = $value;

        return $this;
    }

    /**
     * 
     * 
     * @param   
     * @return  
     */
    public function build()
    {
        
    }
}