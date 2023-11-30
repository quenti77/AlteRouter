# Route

Cette classe représente une route dans le routeur. Vous pouvez créer une instance de cette classe directement, mais
vous pouvez aussi utiliser les méthodes de la classe `AlteRouter\AlteRouter` pour créer une route.

## Sommaire

[[toc]]

## getMethod

```php
Route::getMethod(): string
```

Récupère la méthode HTTP de la route. Les verbes HTTP sont : `GET`, `POST`, `PUT`, `PATCH`, `DELETE`, `HEAD`
et `OPTIONS`.

```php
$route = new Route('GET', '/path', 'callback');
var_dump($route->getMethod()); // string(3) "GET"
```

## getPath

```php
Route::getPath(): string
```

Récupère le chemin que la route doit matcher.

```php
$route = new Route('GET', '/path/to/resource', 'callback');
var_dump($route->getPath()); // string(17) "/path/to/resource"
```

## getHandler

```php
Route::getHandler(): callable|string
```

Récupère le gestionnaire de la route. Le gestionnaire peut être une fonction anonyme ou une chaîne de caractères.

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

Vérifie si le gestionnaire de la route est une fonction anonyme.

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

Récupère le nom de la route. Si la route n'a pas de nom, la méthode retourne `null`.

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

Ajoute une contrainte sur un paramètre de la route. Si la contrainte n'est pas respectée, la route ne matchera pas.

- `string $param` : Le nom du paramètre.
- `string $regex` : L'expression régulière qui doit matcher avec la valeur du paramètre. Cela peut être une expression
  régulière ou un alias de paramètre (voir la classe `AlteRouter\PathParameterAliasRegex`).

```php
$route = new Route('GET', '/path/{id}', 'callback');
$route->where('id', 'int');
// Ou
$route = new Route('GET', '/path/{id}', 'callback');
$route->where('id', '[0-9]+');
```

## match

```php
Route::match(string $path, PathParameterAliasRegex $pathParameterAliasRegex): bool
```

Vérifie si le chemin passé en paramètre matche avec le chemin de la route. Si le chemin matche, la méthode retourne
`true`, sinon elle retourne `false`.

- `string $path` : Le chemin à matcher.
- `PathParameterAliasRegex $pathParameterAliasRegex` : L'objet qui contient les alias de paramètres.

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

Génère un chemin à partir des paramètres passés en paramètre. Si le tableau contient des clefs qui ne sont pas des
paramètres de la route, elles seront ajoutées à la fin du chemin généré en query parameters.

- `array $parameters` : Les paramètres de la route.

```php
$route = new Route('GET', '/path/{id}', 'callback');
var_dump($route->generate(['id' => 123])); // string(10) "/path/123"

$route = new Route('GET', '/path/{id}', 'callback');
var_dump($route->generate(['id' => 123, 'foo' => 'bar', 'page' => 1])); // string(20) "/path/123?foo=bar&page=1"
```
