# Getting Started

## Requirements

- Need to have PHP 8.2 or higher installed.
- Need to have [Composer](https://getcomposer.org/download/) installed.

## Installation

Using your terminal, go to your project folder and run the following command :

```bash
composer require quenti77/alterouter
```

If not already done, add the following code to your php file:

```php
// Change the path according to your project
require __DIR__ . '/vendor/autoload.php';
```

## Usage

### Create a router

To create a router, you just need to instantiate the class `AlteRouter\Alterouter` :

```php
$router = new AlteRouter\Alterouter();
```

If your project is in a subfolder, you need to specify the path of this subfolder :

```php
$router = new AlteRouter\Alterouter('/sub-folder');
```

### Create a route

To create a route, there are several methods:

```php
// Create a route with the generic method "addRoute"
$router->addRoute('GET', '/path', function() {
    echo 'Hello World !';
}, 'route-name');
```

Here are the parameters of the method `addRoute` :

- `string $method` : The HTTP method of the route. The possible values 
  are : `GET`, `POST`, `PUT`, `PATCH`, `DELETE`, `HEAD`, `OPTIONS`.
- `string $path` : The path of the route. The path can contain parameters. The parameters are prefixed with brackets.
  Example : `/path/{id}`.
- `callable|string $callback` : The handler of the route. The handler can be a function or a string.
- `string $name = null` : The name of the route. This parameter is optional.

```php
// Create a route with the method "get"
$router->get('/path', function() {
    echo 'Hello World !';
}, 'route-name');
```

Unlike the `addRoute` method, the `get` method does not take as parameter the HTTP method of the route, because
this method is specific to the `GET` method.

He exists a method for each HTTP method : `get`, `post`, `put`, `patch`, `delete`, `head`, `options`.

### Match a route

To match a route, you just need to call the `match` method with the HTTP method and the URL of the route. You
can use the `AlteRouter\Request` class to get the HTTP method and the URL of the route.

```php
$route = $router->match(AlteRouter\Request::getMethodFromGlobals(), AlteRouter\Request::getPathFromGlobals());
```

If the route is not found, the `match` method returns `null`. Otherwise, it returns an `AlteRouter\Route` object.

### Execute a route

Depending on whether the route found has a handler with an anonymous function or a string, you
must execute the route differently. Here is an example :

```php
$route = $router->match(AlteRouter\Request::getMethodFromGlobals(), AlteRouter\Request::getPathFromGlobals());

if ($route !== null) {
    if (is_string($route->getHandler())) {
        [$controller, $method] = explode('@', $route->getHandler());
        $controller = new $controller();
        $controller->$method($route->getParams());
    } else {
        call_user_func_array($route->getHandler(), $route->getParams());
    }
}
```

This is a simple example to show you how to execute a route. You can code your own system.
