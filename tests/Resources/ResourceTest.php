<?php

use OpenZac\OpenZac;
use OpenZac\Resources\Resource;

class ResourceTest extends PHPUnit_Framework_TestCase
{
    /** @test */
    function it_calls_the_query_builder()
    {
        $resource = new Resource( new OpenZac('token') );

        $builder = $resource->where('id', [123, 234, 345, 456]);

        var_dump($builder);

        $this->assertEquals(1, 1);
    }

}