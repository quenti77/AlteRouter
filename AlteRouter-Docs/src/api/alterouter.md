# AlteRouter

This class represents the router. It allows you to create routes and execute them.

## Table of contents

[[toc]]

## trimPath (static)

```php
AlteRouter::trimPath(string $path): string
```

This method allows you to remove the `/` in excess in the path.

- `string $path` : The path to trim.

```php
var_dump(AlteRouter::trimPath('////path/with////')); // string(9) "path/with"
```

## getRoutes

```php
/** @return array<string, array<Route>> */
AlteRouter::getRoutes(): array
```

Get all routes in an associative array with the HTTP method as key and as value an array of routes (instance of the
Route class) for the HTTP method.

## getNamedRoutes

```php
/** @return array<string, Route> */
AlteRouter::getNamedRoutes(): array
```

Get all named routes in an associative array with the route name as key and as value an instance of the Route class
associated with the route name.

## get, post, put, patch, delete, head, options

```php
AlteRouter::get(string $path, callable|string $callback, string $name = null): Route
AlteRouter::post(string $path, callable|string $callback, string $name = null): Route
AlteRouter::put(string $path, callable|string $callback, string $name = null): Route
AlteRouter::patch(string $path, callable|string $callback, string $name = null): Route
AlteRouter::delete(string $path, callable|string $callback, string $name = null): Route
AlteRouter::head(string $path, callable|string $callback, string $name = null): Route
AlteRouter::options(string $path, callable|string $callback, string $name = null): Route
```

Create a route with the corresponding HTTP method. These methods are shortcuts for the `addRoute` method.

- `string $path` : The path of the route. The path can contain parameters.
- `callable|string $callback` : The function to execute when the route is called. The value can be an anonymous
  function or a string that will be useful to you.
- `string $name = null` : The name of the route. The name of the route is optional.

```php
$router = new AlteRouter\Alterouter();
$router->get('/path', function() {
    echo 'Hello World !';
}, 'route-name');
```

Add a route with the `GET` method and the `/path` path. When the route is called, the anonymous function is executed.
The name of the route is `route-name`.

## addRoute

```php
AlteRouter::addRoute(string $method, string $path, callable|string $callback, string $name = null): Route
```

As with the `get`, `post`, `put`, `patch`, `delete`, `head`, `options` methods, this method allows you to create a
route. The difference is that this method allows you to create a route with any HTTP method.

```php
$router = new AlteRouter\Alterouter();
$router->addRoute('GET', '/path', function() {
    echo 'Hello World !';
}, 'route-name');
```

## addMultipleMethodRoutes

```php
/**
 * @param array<string>|string $methods
 * @param string $path
 * @param callable|string $callback
 * @return array<Route>
 */
AlteRouter::addMultipleMethodRoutes(array|string $methods, string $path, callable|string $callback): array
```

This method allows you to create multiple routes with multiple HTTP methods for the same path.

- `array|string $methods` : The HTTP methods to use. The value can be an array of strings or a string with the HTTP
  methods separated by `|`.
- `string $path` : The path of the route. The path can contain parameters.
- `callable|string $callback` : The function to execute when the route is called. The value can be an anonymous
  function or a string that will be useful to you.

```php
$router = new AlteRouter\Alterouter();
$router->addMultipleMethodRoutes(['GET', 'POST'], '/path/with/array', function() {
    echo 'Hello World 1!';
});
$router->addMultipleMethodRoutes('GET|POST', '/path/with/string', function() {
    echo 'Hello World 2!';
});
```

## match

```php
AlteRouter::match(string $path, string $method): ?Route
```

This method allows you to get the route corresponding to the path and the HTTP method. If no route is found, the value
`null` is returned.

- `string $path` : The path to match.
- `string $method` : The HTTP method to match.

To get the information of the route parameters, you can use the methods of the `Request` class ([see here](./request)).

**Example : route matches the URL**

```php
$router = new AlteRouter\Alterouter();
$router->get('/path', function() {
    echo 'Hello World !';
}, 'route-name');

$route = $router->match('/path', 'GET');
var_dump($route->getName()); // string(10) "route-name"
```

**Example: route does not match the URL**

```php
$router = new AlteRouter\Alterouter();
$router->get('/path', function() {
    echo 'Hello World !';
}, 'route-name');

$route = $router->match('/path', 'POST');
var_dump($route); // null
```

## generate

```php
AlteRouter::generate(string $name, array $params = []): string
```

This method allows you to generate an URL from the route name and parameters. If the route is not found, an exception
is thrown.

- `string $name` : The name of the route.
- `array $params = []` : The parameters of the route. You must indicate the parameters in an associative array with
  the parameter name as key and the parameter value as value. If you specify a parameter that does not exist in the
  route, then it is added to the end of the URL as a GET parameter `?key=value&key2=value2`.

```php
$router = new AlteRouter\Alterouter();
$router->get('/path/{id}', function() {
    echo 'Hello World !';
}, 'route-name');

$url = $router->generate('route-name', ['id' => 1]);
var_dump($url); // string(10) "/path/1"

$url = $router->generate('route-name', ['id' => 1, 'key' => 'value']);
var_dump($url); // string(18) "/path/1?key=value"
```
