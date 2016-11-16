<?php

use OpenZac\ApiResource;

class ApiResourceTest extends PHPUnit_Framework_TestCase
{
    /** @test */
    function it_returns_an_attribute()
    {
        $resource = new ApiResource;

        $resource->setAttributes([
            'id' => 1
        ]);

        $this->assertEquals(1, $resource->id);
    }

    /** @test */
    function it_returns_casted_attributes()
    {
        $resource = new ApiResource;

        $resource->setAttributes([
            'integer' => '1',
            'boolean' => '0',
            'date' => date('U')
        ]);

        $resource->setCasts([
            'integer' => 'integer',
            'boolean' => 'boolean',
            'date' => 'date'
        ]);

        $this->assertEquals(1, $resource->integer);
        $this->assertEquals(false, $resource->boolean);
        $this->assertInstanceOf(\Carbon\Carbon::class, $resource->date);
    }
}