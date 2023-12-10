<?php

namespace Alterouter\Tests;

use Alterouter\Request;
use PHPUnit\Framework\TestCase;

class RequestTest extends TestCase
{
    public function testItReturnsGetMethodFromGlobals(): void
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';

        $this->assertSame('GET', Request::getMethodFromGlobals());
    }

    public function testItReturnsPostMethodFromGlobals(): void
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';

        $this->assertSame('POST', Request::getMethodFromGlobals());
    }

    public function testItReturnsPathFromGlobals(): void
    {
        $_SERVER['REQUEST_URI'] = '/foo/bar';

        $this->assertSame('/foo/bar', Request::getPathFromGlobals());
    }

    public function testItReturnsPathFromGlobalsWithQueryString(): void
    {
        $_SERVER['REQUEST_URI'] = '/foo/bar?baz=qux';

        $this->assertSame('/foo/bar', Request::getPathFromGlobals());
    }
}
