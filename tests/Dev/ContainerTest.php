<?php

namespace Tests\Dev;

use Tests\TestCase;
use Illuminate\Container\Container;

class ContainerTest extends TestCase {


    public function setUp() {
        $this->container = Container::getInstance();
    }

    public function testFirst() {
        $str = 'jack';
        $this->container->bind('jack', function() {
            return 'jack';
        });
        $expected = $this->container->make('jack');
        $this->assertEquals($str, $expected);
    }
}