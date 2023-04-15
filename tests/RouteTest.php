<?php

namespace Alterouter\Tests;

use Alterouter\PathParameterAliasRegex;
use Alterouter\Route;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class RouteTest extends TestCase
{
    private PathParameterAliasRegex $aliases;

    protected function setUp(): void
    {
        parent::setUp();

        $this->aliases = new PathParameterAliasRegex();
    }

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

    public function testItDoesNotMatchPathWithBadPath(): void
    {
        $route = new Route('GET', '/blog', function () {
        });
        $this->assertFalse($route->match('/forum', $this->aliases));
    }

    public function testItDoesNotMatchPathWithBadParameters(): void
    {
        $route = new Route('GET', '/blog/{id:int}', function () {
        });
        $this->assertFalse($route->match('/blog/abc', $this->aliases));
    }

    public function testItMatchesPathWithGoodParametersInPath(): void
    {
        $route = new Route('GET', '/blog/{id:int}', function () {
        });

        $this->assertTrue($route->match('/blog/123', $this->aliases));
        $this->assertSame(['id' => '123'], $route->getMatches());
    }

    public function testItMatchesPathWithGoodParametersSetWithAlias(): void
    {
        $route = new Route('GET', '/blog/{id}', function () {
        });
        $route->where('id', 'int');

        $this->assertTrue($route->match('/blog/123', $this->aliases));
        $this->assertSame(['id' => '123'], $route->getMatches());
    }

    public function testItMatchesPathWithGoodParametersSetWithRegex(): void
    {
        $route = new Route('GET', '/blog/{id}', function () {
        });
        $route->where('id', '[0-9]+');

        $this->assertTrue($route->match('/blog/123', $this->aliases));
        $this->assertSame(['id' => '123'], $route->getMatches());
    }

    public function testItThrowsExceptionWithBadAlias(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Alias 'foo' is not defined");

        $route = new Route('GET', '/blog/{id:foo}', function () {
        });
        $route->match('/blog/123', $this->aliases);
    }

    public function testItMatchesPathWithMultipleParameters(): void
    {
        $route = new Route('GET', '/blog/{id:int}/{slug}/{page}', function () {
        });
        $route->where('slug', 'slug');
        $route->where('page', '[0-9]+');

        $this->assertTrue($route->match('/blog/123/foo-bar/1', $this->aliases));
        $this->assertSame([
            'id' => '123',
            'slug' => 'foo-bar',
            'page' => '1',
        ], $route->getMatches());
    }
}
