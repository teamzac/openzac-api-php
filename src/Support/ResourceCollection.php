<?php

namespace TeamZac\OpenZac\Support;

use Illuminate\Support\Collection;

class ResourceCollection
{
    protected $data;

    protected $meta;

    /**
     * 
     * 
     * @param   
     * @return  
     */
    public function __construct($response)
    {
        $this->data = $response->data;
        if ( isset($response->meta)) {
            $this->meta = $response->meta; 
        } 
    }

    /**
     * 
     * 
     * @param   
     * @return  
     */
    public function data()
    {
        return Collection::make($this->data);
    }

    /**
     * Get the metadata associated with this resource collection
     * 
     * @param   
     * @return  
     */
    public function meta()
    {
        return $this->meta;
    }

    /**
     * 
     * 
     * @param   
     * @return  
     */
    public function nextPage()
    {
        if ( isset($this->meta->pagination) && $this->meta->pagination->current_page < $this->meta->pagination->total_pages ) 
        {
            return $this->meta->pagination->current_page + 1;
        }
    }

    /**
     * 
     * 
     * @param   
     * @return  
     */
    public function previousPage()
    {
        if ( isset($this->meta->pagination) && $this->meta->pagination->current_page > 1 ) 
        {
            return $this->meta->pagination->current_page - 1;
        }
    }
}