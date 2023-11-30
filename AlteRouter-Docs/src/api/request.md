# Request

Can simplify the recovery of HTTP request information. We can retrieve the following information:
- The path of the request
- The HTTP method of the request

## Table of contents

[[toc]]

## getMethodFromGlobals (static)

```php
Request::getMethodFromGlobals(): string
```

This method allows you to retrieve the HTTP method of the request from the global variable `$_SERVER`.

```php
// If the HTTP method is GET
var_dump(Request::getMethodFromGlobals()); // string(3) "GET"

// If the HTTP method is POST
var_dump(Request::getMethodFromGlobals()); // string(4) "POST"
```

## getPathFromGlobals (static)

```php
Request::getPathFromGlobals(): string
```

This method allows you to retrieve the path of the request from the global variable `$_SERVER`.

```php
// If the path is /path/to/resource
var_dump(Request::getPathFromGlobals()); // string(17) "/path/to/resource"

// If the path is /path/to/resource?foo=bar
var_dump(Request::getPathFromGlobals()); // string(17) "/path/to/resource"
```
