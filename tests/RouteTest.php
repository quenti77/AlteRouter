<?php

namespace Alterouter\Tests;

use Alterouter\Route;
use PHPUnit\Framework\TestCase;

class RouteTest extends TestCase
{
    public function testItReturnsNotCallableWithStringCallable(): void
    {
        $route = new Route('GET', '/', 'foo');
        $this->assertFalse($route->isCallable());
    }

    public function testItReturnsCallableWithClosureCallable(): void
    {
        $route = new Route('GET', '/', function () {
        });
        $this->assertTrue($route->isCallable());
    }
}
