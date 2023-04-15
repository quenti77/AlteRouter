<?php

namespace Alterouter\Tests;

use Alterouter\PathParameterAliasRegex;
use PHPUnit\Framework\TestCase;

class PathParameterAliasRegexTest extends TestCase
{
    public function testItReturnsDefaultAliases(): void
    {
        $aliases = new PathParameterAliasRegex();
        $this->assertSame([
            'int' => '[0-9]+',
            'float' => '[0-9]+(?:\.[0-9]+)?',
            'slug' => '[a-zA-Z0-9_\-]+',
            '__all' => '[^\/]+',
        ], $aliases->getAliases());
    }

    public function testItReturnsCustomAliases(): void
    {
        $aliases = new PathParameterAliasRegex([
            'foo' => 'bar',
        ]);
        $this->assertSame([
            'int' => '[0-9]+',
            'float' => '[0-9]+(?:\.[0-9]+)?',
            'slug' => '[a-zA-Z0-9_\-]+',
            '__all' => '[^\/]+',
            'foo' => 'bar',
        ], $aliases->getAliases());
    }

    public function testItAddsAlias(): void
    {
        $aliases = new PathParameterAliasRegex();
        $aliases->addAlias('foo', 'bar');
        $this->assertSame([
            'int' => '[0-9]+',
            'float' => '[0-9]+(?:\.[0-9]+)?',
            'slug' => '[a-zA-Z0-9_\-]+',
            '__all' => '[^\/]+',
            'foo' => 'bar',
        ], $aliases->getAliases());
    }

    public function testItAddsAliasWithExistingAlias(): void
    {
        $aliases = new PathParameterAliasRegex([
            'foo' => 'bar',
        ]);
        $this->assertSame([
            'int' => '[0-9]+',
            'float' => '[0-9]+(?:\.[0-9]+)?',
            'slug' => '[a-zA-Z0-9_\-]+',
            '__all' => '[^\/]+',
            'foo' => 'bar',
        ], $aliases->getAliases());

        $aliases->addAlias('foo', 'baz');
        $this->assertSame([
            'int' => '[0-9]+',
            'float' => '[0-9]+(?:\.[0-9]+)?',
            'slug' => '[a-zA-Z0-9_\-]+',
            '__all' => '[^\/]+',
            'foo' => 'baz',
        ], $aliases->getAliases());
    }
}
