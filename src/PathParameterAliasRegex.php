<?php

namespace Alterouter;

class PathParameterAliasRegex
{
    /** @var array<string, string> DEFAULT_ALIASES */
    private const DEFAULT_ALIASES = [
        'int' => '[0-9]+',
        'float' => '[0-9]+(?:\.[0-9]+)?',
        'slug' => '[a-zA-Z0-9_\-]+',
        '__all' => '[^\/]+',
    ];

    public function __construct(
        /** @var array<string, string> $aliases */
        private array $aliases = [],
    ) {
        $this->aliases = array_merge(self::DEFAULT_ALIASES, $aliases);
    }

    /** @return array<string, string> */
    public function getAliases(): array
    {
        return $this->aliases;
    }

    public function addAlias(string $alias, string $regex): void
    {
        $this->aliases[$alias] = $regex;
    }
}
