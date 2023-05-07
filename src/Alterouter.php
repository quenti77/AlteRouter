<?php

namespace Alterouter;

use InvalidArgumentException;

class Alterouter
{
    public const METHODS = ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS'];

    /** @var array<string, array<Route>> */
    protected array $routes = [];

    /** @var array<string, Route> */
    protected array $namedRoutes = [];

    protected PathParameterAliasRegex $pathParameterAliasRegex;

    /** @param array<string, string> $aliases */
    public function __construct(
        private string $basePath = '',
        array $aliases = [],
    ) {
        $this->basePath = self::trimPath($basePath);
        $this->pathParameterAliasRegex = new PathParameterAliasRegex($aliases);
    }

    public static function trimPath(string $path): string
    {
        return trim($path, '/');
    }

    /** @return array<string, array<Route>> */
    public function getRoutes(): array
    {
        return $this->routes;
    }

    /** @return array<string, Route> */
    public function getNamedRoutes(): array
    {
        return $this->namedRoutes;
    }

    public function get(string $path, callable|string $handler, ?string $name = null): Route
    {
        return $this->addRoute('GET', $path, $handler, $name);
    }

    public function post(string $path, callable|string $handler, ?string $name = null): Route
    {
        return $this->addRoute('POST', $path, $handler, $name);
    }

    public function put(string $path, callable|string $handler, ?string $name = null): Route
    {
        return $this->addRoute('PUT', $path, $handler, $name);
    }

    public function patch(string $path, callable|string $handler, ?string $name = null): Route
    {
        return $this->addRoute('PATCH', $path, $handler, $name);
    }

    public function delete(string $path, callable|string $handler, ?string $name = null): Route
    {
        return $this->addRoute('DELETE', $path, $handler, $name);
    }

    public function head(string $path, callable|string $handler, ?string $name = null): Route
    {
        return $this->addRoute('HEAD', $path, $handler, $name);
    }

    public function options(string $path, callable|string $handler, ?string $name = null): Route
    {
        return $this->addRoute('OPTIONS', $path, $handler, $name);
    }

    public function addRoute(string $method, string $path, callable|string $handler, ?string $name = null): Route
    {
        $method = strtoupper(trim($method));
        if (!in_array($method, self::METHODS)) {
            throw new InvalidArgumentException("Invalid HTTP method '$method'.");
        }

        $path = self::trimPath($path);
        if (!empty($this->basePath)) {
            $path = $this->basePath . '/' . $path;
        }

        $route = new Route($method, $path, $handler, $name);
        $this->routes[$method][] = $route;
        if ($name) {
            $this->namedRoutes[$name] = $route;
        }

        return $route;
    }

    /**
     * @param array<string> $methods
     * @return array<Route>
     */
    public function addMultipleMethodRoutes(array|string $methods, string $path, callable|string $handler): array
    {
        if (is_string($methods)) {
            $methods = explode('|', $methods);
        }

        $routes = [];
        foreach ($methods as $method) {
            $routes[] = $this->addRoute($method, $path, $handler);
        }
        return $routes;
    }

    public function match(string $method, string $path): ?Route
    {
        $method = strtoupper(trim($method));
        if (!in_array($method, self::METHODS)) {
            return null;
        }

        if (!isset($this->routes[$method])) {
            return null;
        }

        $path = self::trimPath($path);
        foreach ($this->routes[$method] as $route) {
            if ($route->match($path, $this->pathParameterAliasRegex)) {
                return $route;
            }
        }

        return null;
    }

    /**
     * @param array<string, string> $parameters
     */
    public function generate(string $name, array $parameters = []): string
    {
        if (!isset($this->namedRoutes[$name])) {
            throw new InvalidArgumentException("No route found for name '{$name}'");
        }
        $generatedPath = $this->namedRoutes[$name]->generate($parameters);

        return "/{$generatedPath}";
    }
}
