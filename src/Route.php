<?php

namespace Alterouter;

use InvalidArgumentException;

class Route
{
    /** @var callable|string $handler */
    private $handler;

    /** @var array<string, string> $pathParameters */
    private array $pathParameters = [];

    /** @var array<string, string> $matches */
    private array $matches = [];

    public function __construct(
        private readonly string $method,
        private readonly string $path,
        callable|string $handler,
        private readonly ?string $name = null,
    ) {
        $this->handler = $handler;
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function getHandler(): callable|string
    {
        return $this->handler;
    }

    public function isCallable(): bool
    {
        return is_callable($this->handler);
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    /** @return array<string, string> */
    public function getMatches(): array
    {
        return $this->matches;
    }

    public function where(string $parameter, string $regex): Route
    {
        $this->pathParameters[$parameter] = $regex;

        return $this;
    }

    public function match(string $path, PathParameterAliasRegex $pathParameterAliasRegex): bool
    {
        $pathAlias = $pathParameterAliasRegex->getAliases();

        $pathRegex = preg_replace_callback(
            '/\{([a-zA-Z0-9_\-]+)(?::([a-zA-Z0-9_\-]+))?}/',
            fn (array $matches) => $this->transformPathMatcher($matches, $pathAlias),
            $this->path,
        );

        $matches = [];
        if (!preg_match("#^{$pathRegex}$#", $path, $matches)) {
            return false;
        }

        array_shift($matches);
        foreach ($matches as $key => $value) {
            if (is_string($key)) {
                $this->matches[$key] = $value;
            }
        }

        return true;
    }

    /**
     * @param array<int|string, string> $matches
     * @param array<string, string> $aliases
     * @return string
     */
    private function transformPathMatcher(array $matches, array $aliases): string
    {
        array_shift($matches);
        if (empty($matches)) {
            throw new InvalidArgumentException('Path matcher is empty');
        }

        if (count($matches) === 1) {
            $matches[] = '__all';
        }
        [$parameter, $alias] = $matches;

        $pathParam = $this->pathParameters[$parameter] ?? null;
        $pathRegex = $aliases[$pathParam]
            ?? $pathParam
            ?? $aliases[$alias]
            ?? throw new InvalidArgumentException("Alias '{$alias}' is not defined");

        return "(?P<{$parameter}>{$pathRegex})";
    }
}
