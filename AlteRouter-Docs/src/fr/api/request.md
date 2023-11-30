# Request

Permet de simplifier la récupération des informations de la requête HTTP. On peut récupérer les informations suivantes :
- Le chemin de la requête
- La méthode HTTP de la requête

## Sommaire

[[toc]]

## getMethodFromGlobals (static)

```php
Request::getMethodFromGlobals(): string
```

Cette méthode permet de récupérer la méthode HTTP de la requête à partir de la variable globale `$_SERVER`.

```php
// Si la méthode HTTP est GET
var_dump(Request::getMethodFromGlobals()); // string(3) "GET"

// Si la méthode HTTP est POST
var_dump(Request::getMethodFromGlobals()); // string(4) "POST"
```

## getPathFromGlobals (static)

```php
Request::getPathFromGlobals(): string
```

Cette méthode permet de récupérer le chemin de la requête à partir de la variable globale `$_SERVER`.

```php
// Si le chemin est /path/to/resource
var_dump(Request::getPathFromGlobals()); // string(17) "/path/to/resource"

// Si le chemin est /path/to/resource?foo=bar
var_dump(Request::getPathFromGlobals()); // string(17) "/path/to/resource"
```
