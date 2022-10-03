<?php

declare(strict_types = 1);

namespace Tests;

class ExampleTest
    extends TestCase
{
    public function testExample()
    {
        $this->get('/');
        $this->assertEquals($this->app->version(), $this->response->getContent());
    }
}
