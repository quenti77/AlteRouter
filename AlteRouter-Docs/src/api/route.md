# Route

This class represents a route in the router. You can create an instance of this class directly, but you can also use
the methods of the `AlteRouter\AlteRouter` class to create a route.

## Table of contents

[[toc]]

## getMethod

```php
Route::getMethod(): string
```

Get the HTTP method of the route. The HTTP verbs are: `GET`, `POST`, `PUT`, `PATCH`, `DELETE`, `HEAD` and `OPTIONS`.

```php
$route = new Route('GET', '/path', 'callback');
var_dump($route->getMethod()); // string(3) "GET"
```

## getPath

```php
Route::getPath(): string
```

Get the path that the route must match.

```php
$route = new Route('GET', '/path/to/resource', 'callback');
var_dump($route->getPath()); // string(17) "/path/to/resource"
```

## getHandler

```php
Route::getHandler(): callable|string
```

Get the handler of the route. The handler can be an anonymous function or a string.

```php
$route = new Route('GET', '/path', 'callback');
var_dump($route->getHandler()); // string(8) "callback"

$route = new Route('GET', '/path', function () {
    echo 'Hello world';
});
var_dump($route->getHandler()); // php callable
```

## isCallable

```php
Route::isCallable(): bool
```

Check if the route handler is an anonymous function.

```php
$route = new Route('GET', '/path', 'callback');
var_dump($route->isCallable()); // bool(false)

$route = new Route('GET', '/path', function () {
    echo 'Hello world';
});
var_dump($route->isCallable()); // bool(true)
```

## getName

```php
Route::getName(): string|null
```

Get the name of the route. If the route has no name, the method returns `null`.

```php
$route = new Route('GET', '/path', 'callback');
var_dump($route->getName()); // NULL

$route = new Route('GET', '/path', 'callback', 'route_name');
var_dump($route->getName()); // string(10) "route_name"
```

## where

```php
Route::where(string $param, string $regex): Route
```

Add a constraint on a route parameter. If the constraint is not respected, the route will not match.

- `string $param` : The name of the parameter.
- `string $regex` : The regular expression that must match with the value of the parameter. It can be a regular
  expression or a parameter alias (see the `AlteRouter\PathParameterAliasRegex` class).

```php
$route = new Route('GET', '/path/{id}', 'callback');
$route->where('id', 'int');
// Or
$route = new Route('GET', '/path/{id}', 'callback');
$route->where('id', '[0-9]+');
```

## match

```php
Route::match(string $path, PathParameterAliasRegex $pathParameterAliasRegex): bool
```

Check if the path passed in parameter matches with the path of the route. If the path matches, the method returns
`true`, otherwise it returns `false`.

- `string $path` : The path to match.
- `PathParameterAliasRegex $pathParameterAliasRegex` : The object that contains the parameter aliases.

```php
$route = new Route('GET', '/path/{id:int}', 'callback');
var_dump($route->match('/path/123')); // bool(true)

$route = new Route('GET', '/path/{id}', 'callback');
$route->where('id', 'int');
var_dump($route->match('/path/123')); // bool(true)

$route = new Route('GET', '/path/{id:int}', 'callback');*
var_dump($route->match('/path/abc')); // bool(false)
```

## generate

```php
Route::generate(array $parameters): string
```

Generate a path from the parameters passed in parameter. If the array contains keys that are not parameters of the
route, they will be added at the end of the generated path in query parameters.

- `array $parameters` : The parameters of the route.

```php
$route = new Route('GET', '/path/{id}', 'callback');
var_dump($route->generate(['id' => 123])); // string(10) "/path/123"

$route = new Route('GET', '/path/{id}', 'callback');
var_dump($route->generate(['id' => 123, 'foo' => 'bar', 'page' => 1])); // string(20) "/path/123?foo=bar&page=1"
```
