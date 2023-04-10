<?php

namespace Alterouter;

class Route
{
    /** @var callable|string $handler */
    private $handler;

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
}
