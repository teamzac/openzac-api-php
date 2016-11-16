<?php

namespace TeamZac\OpenZac\Support;

use Carbon\Carbon;
use Illuminate\Support\Collection;

class Resource
{
    /**
     * The resource's attributes.
     *
     * @var array
     */
    protected $attributes = [];

    /**
     * The resource's metadata.
     *
     * @var array
     */
    protected $meta = [];

    /**
     * The attributes to cast to specific data types
     *
     * @var array
     */
    protected $casts = [];

    /**
     * The default date format
     *
     * @var array
     */
    protected $dateFormat = 'Y-m-d';

    /**
     * 
     * 
     * @param   
     * @return  
     */
    public function __construct($response)
    {
        $this->attributes = (array)$response->data;
        // $this->meta = (array)$response->meta;
    }

    /**
     * 
     * 
     * @param   
     * @return  
     */
    public function __get($key)
    {
        if (array_key_exists($key, $this->attributes))
        {
            return $this->getAttributeValue($key);
        }
    }

    /**
     * 
     * 
     * @param   
     * @return  
     */
    public function getAttributeValue($key)
    {
        $value = $this->getAttributeFromArray($key);

        if ( $this->hasCast($key) )
        {
            return $this->castAttribute($key, $value);
        }

        return $value;
    }

    /**
     * 
     * 
     * @param   
     * @return  
     */
    public function getAttributeFromArray($key)
    {
        if (array_key_exists($key, $this->attributes)) 
        {
            return $this->attributes[$key];
        }
    }

    /**
     * 
     * 
     * @param   string  $key
     * @return  boolean
     */
    public function hasCast($key)
    {
        return array_key_exists($key, $this->casts);
    }

    /**
     * 
     * 
     * @param   array
     * @return  
     */
    public function setCasts($casts)
    {
        $this->casts = $casts;
    }

    /**
     * 
     * 
     * @param   
     * @return  
     */
    public function mergeCasts($newCasts)
    {
        $this->casts = array_merge($newCasts, $this->casts);
    }

    /**
     * 
     * 
     * @param   
     * @return  
     */
    public function castAttribute($key, $value)
    {
        if ( is_null($value) ) 
        {
            return $value;
        }

        switch ($this->getCastType($key)) 
        {
            case 'int':
            case 'integer':
                return (int) $value;
            case 'real':
            case 'float':
            case 'double':
                return (float) $value;
            case 'string':
                return (string) $value;
            case 'bool':
            case 'boolean':
                return (bool) $value;
            case 'object':
                return $this->fromJson($value, true);
            case 'array':
            case 'json':
                return $this->fromJson($value);
            case 'collection':
                return new Collection($value);
            case 'date':
            case 'datetime':
                return $this->asDateTime($value);
            case 'timestamp':
                return $this->asTimeStamp($value);
            default:
                return $value;
        }
    }

    /**
     * 
     * 
     * @param   
     * @return  
     */
    public function getCastType($key)
    {
        if ( $this->hasCast($key) ) 
        {
            return $this->casts[$key];
        }
    }

    /**
     * Decode the given JSON back into an array or object.
     *
     * @param  string  $value
     * @param  bool  $asObject
     * @return mixed
     */
    public function fromJson($value, $asObject = false)
    {
        return json_decode($value, !$asObject);
    }

    /**
     * Return a timestamp as DateTime object.
     *
     * @param  mixed  $value
     * @return \Carbon\Carbon
     */
    protected function asDateTime($value)
    {
        if ($value instanceof Carbon)
        {
            return $value;
        }

         // If the value is already a DateTime instance, we will just skip the rest of
         // these checks since they will be a waste of time, and hinder performance
         // when checking the field. We will just return the DateTime right away.
        if ($value instanceof DateTimeInterface) {
            return new Carbon(
                $value->format('Y-m-d H:i:s.u'), $value->getTimeZone()
            );
        }

        // If this value is an integer, we will assume it is a UNIX timestamp's value
        // and format a Carbon object from this timestamp. This allows flexibility
        // when defining your date fields as they might be UNIX timestamps here.
        if (is_numeric($value)) {
            return Carbon::createFromTimestamp($value);
        }

        // Finally, we will just assume this date is in the format used by default on
        // the database connection and use that format to create the Carbon object
        // that is returned back out to the developers after we convert it here.
        return Carbon::createFromFormat($this->getDateFormat(), $value);
    }

    /**
     * Return a timestamp as unix timestamp.
     *
     * @param  mixed  $value
     * @return int
     */
    protected function asTimeStamp($value)
    {
        return $this->asDateTime($value)->getTimestamp();
    }

    /**
     * Get the format for database stored dates.
     *
     * @return string
     */
    protected function getDateFormat()
    {
        return $this->dateFormat;
    }

    /**
     * 
     * 
     * @param   
     * @return  
     */
    public function setAttributes($attributes)
    {
        $this->attributes = $attributes;
    }

    /**
     * 
     * 
     * @param   
     * @return  
     */
    public static function hydrate(array $items)
    {
        $objects = array_map(function($item) use ($instance) {
            $instance = new static;
            $instance->setAttributes($items);
            return $instance;
        }, $items);
        
        return new Collection($objects);
    }

}