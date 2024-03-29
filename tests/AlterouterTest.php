<?php

namespace Alterouter\Tests;

use Alterouter\Alterouter;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class AlterouterTest extends TestCase
{
    public function testItReturnsEmptyStringWhenTrimmingEmptyString(): void
    {
        $this->assertSame('', Alterouter::trimPath(''));
    }

    public function testItReturnsEmptyStringWhenTrimmingStringWithOnlySlashes(): void
    {
        $this->assertSame('', Alterouter::trimPath('////'));
    }

    public function testItReturnsTrimmedStringWhenTrimmingStringWithSlashes(): void
    {
        $this->assertSame('foo/bar', Alterouter::trimPath('/foo/bar/'));
    }

    public function testItThrowsExceptionWhenAddingRouteWithInvalidMethod(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Invalid HTTP method 'FOO'.");

        $router = new Alterouter();
        $router->addRoute('FOO', '/', function () {
        });
    }

    public function testItAddsGetRouteWithoutBasePath(): void
    {
        $router = new Alterouter();
        $route = $router->addRoute('GET', '/', function () {
        });

        $this->assertSame('GET', $route->getMethod());
        $this->assertSame('', $route->getPath());
        $this->assertCount(1, $router->getRoutes());
        $this->assertCount(0, $router->getNamedRoutes());
    }

    public function testItAddsPostNamedRouteWithoutBasePath(): void
    {
        $router = new Alterouter();
        $route = $router->addRoute('POST', '/foo/bar', function () {
        }, 'foo.bar');

        $this->assertSame('POST', $route->getMethod());
        $this->assertSame('foo/bar', $route->getPath());
        $this->assertSame('foo.bar', $route->getName());
        $this->assertIsCallable($route->getHandler());
        $this->assertCount(1, $router->getRoutes());
        $this->assertCount(1, $router->getNamedRoutes());
    }

    public function testItAddsPutRouteWithBasePath(): void
    {
        $router = new Alterouter('/api/');
        $route = $router->addRoute('PUT', '/foo/bar', function () {
        });

        $this->assertSame('PUT', $route->getMethod());
        $this->assertSame('api/foo/bar', $route->getPath());
        $this->assertCount(1, $router->getRoutes());
        $this->assertCount(0, $router->getNamedRoutes());
    }

    /** @dataProvider getMethodsProvider */
    public function testItAddsRouteWithHelpers(string $method): void
    {
        $router = new Alterouter();
        $route = $router->{$method}('/foo/bar', function () {
        });

        $this->assertSame(strtoupper($method), $route->getMethod());
        $this->assertSame('foo/bar', $route->getPath());
        $this->assertCount(1, $router->getRoutes());
        $this->assertCount(0, $router->getNamedRoutes());
    }

    /** @return array<string, array<string>> */
    public static function getMethodsProvider(): array
    {
        return [
            'add "get" routes' => ['get'],
            'add "post" routes' => ['post'],
            'add "put" routes' => ['put'],
            'add "patch" routes' => ['patch'],
            'add "delete" routes' => ['delete'],
            'add "head" routes' => ['head'],
            'add "options" routes' => ['options'],
        ];
    }

    public function testItAddsMultipleMethodsForSamePathWithString(): void
    {
        $router = new Alterouter();
        $router->addMultipleMethodRoutes('get|post', '/foo/bar', function () {
        });

        $this->assertCount(2, $router->getRoutes());
        $this->assertCount(0, $router->getNamedRoutes());
    }

    public function testItAddsMultipleMethodsForSamePathWithArray(): void
    {
        $router = new Alterouter();
        $router->addMultipleMethodRoutes(['get', 'post'], '/foo/bar', function () {
        });

        $this->assertCount(2, $router->getRoutes());
        $this->assertCount(0, $router->getNamedRoutes());
    }

    public function testItThrowsInvalidArgumentExceptionWithInvalidMethod(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Invalid HTTP method 'FOO'.");

        $router = new Alterouter();
        $router->addMultipleMethodRoutes('foo', '/foo/bar', function () {
        });
    }

    public function testItReturnsNullWhenBadMethodPassed(): void
    {
        $router = new Alterouter();
        $router->addRoute('GET', '/foo/bar', function () {
        });

        $this->assertNull($router->match('FOO', '/foo/bar'));
    }

    public function testItReturnsNullWhenNoRoutesExistForThisMethod(): void
    {
        $router = new Alterouter();
        $router->addRoute('GET', '/foo/bar', function () {
        });

        $this->assertNull($router->match('POST', '/foo/bar'));
    }

    public function testItReturnsNullWhenNoRoutesExistForThisPath(): void
    {
        $router = new Alterouter();
        $router->addRoute('GET', '/foo/bar', function () {
        });

        $this->assertNull($router->match('GET', '/foo/baz'));
    }

    public function testItReturnsRouteWhenRouteExists(): void
    {
        $router = new Alterouter();
        $route = $router->addRoute('GET', '/foo/bar', function () {
        });

        $this->assertSame($route, $router->match('GET', '/foo/bar'));
    }

    public function testItThrowsInvalidArgumentExceptionWhenNamedRouteNotFound(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("No route found for name 'foo'");

        $router = new Alterouter();
        $router->generate('foo');
    }

    public function testItGeneratesUrlForNamedRoute(): void
    {
        $router = new Alterouter();
        $router->addRoute('GET', '/foo/bar', function () {
        }, 'foo.bar');

        $this->assertSame('/foo/bar', $router->generate('foo.bar'));
    }

    public function testItGeneratesUrlForNamedRouteWithParameters(): void
    {
        $router = new Alterouter();
        $router->addRoute('GET', '/foo/{bar}', function () {
        }, 'foo.bar');

        $this->assertSame('/foo/baz', $router->generate('foo.bar', ['bar' => 'baz']));
    }

    public function testItGeneratesUrlForNamedRouteWithParametersAndBasePath(): void
    {
        $router = new Alterouter('/api/');
        $router->addRoute('GET', '/foo/{bar}', function () {
        }, 'foo.bar');

        $this->assertSame('/api/foo/baz', $router->generate('foo.bar', ['bar' => 'baz']));
    }

    public function testItGeneratesUrlForNamedRouteWithParametersAndBasePathWithAdditionnalQueryString(): void
    {
        $router = new Alterouter('/api/');
        $router->addRoute('GET', '/foo/{bar}', function () {
        }, 'foo.bar');

        $this->assertSame('/api/foo/baz?foo=bar', $router->generate('foo.bar', ['bar' => 'baz', 'foo' => 'bar']));
    }
}
