<?php

use PHPUnit\Framework\TestCase;

class FrameworkTest extends TestCase
{
    public function testOne(){

        $example = 'Hello';
        $this->assertEquals('Hello', $example);
    }
}