# AlteRouter

Cette classe représente le routeur. Elle permet de créer des routes et de les exécuter.

## Sommaire

[[toc]]

## trimPath (static)

```php
AlteRouter::trimPath(string $path): string
```

Cette méthode permet de supprimer les `/` en trop dans le chemin.

- `string $path` : Le chemin à nettoyer.

```php
var_dump(AlteRouter::trimPath('////path/with////')); // string(9) "path/with"
```

## getRoutes

```php
/** @return array<string, array<Route>> */
AlteRouter::getRoutes(): array
```

Récupère toutes les routes dans un tableau associatif avec comme clé la méthode HTTP et comme valeur un tableau des
routes (instance de la classe Route) pour la méthode HTTP.

## getNamedRoutes

```php
/** @return array<string, Route> */
AlteRouter::getNamedRoutes(): array
```

Récupère toutes les routes nommées dans un tableau associatif avec comme clé le nom de la route et comme valeur
l'instance de la classe Route associée au nom de la route.

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

Crée une route avec la méthode HTTP correspondante. Ces méthodes sont des raccourcis de la méthode `addRoute`.

- `string $path` : Le chemin de la route. Ce chemin peut contenir des paramètres.
- `callable|string $callback` : La fonction à exécuter lorsque la route est appelée. La valeur peut être une fonction
  anonyme ou une chaîne de caractères qui vous sera utile pour vous.
- `string $name = null` : Le nom de la route. Ce paramètre est optionnel.

```php
$router = new AlteRouter\Alterouter();
$router->get('/path', function() {
    echo 'Hello World !';
}, 'route-name');
```

Ajoute une route avec la méthode `GET` et le chemin `/path`. Lorsque la route est appelée, la fonction anonyme est
exécutée. Le nom de la route est `route-name`.

## addRoute

```php
AlteRouter::addRoute(string $method, string $path, callable|string $callback, string $name = null): Route
```

Tout comme les méthodes `get`, `post`, `put`, `patch`, `delete`, `head`, `options`, cette méthode permet de créer une
route. La différence est que cette méthode permet de créer une route avec n'importe quelle méthode HTTP.

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

Cette méthode permet de créer plusieurs routes avec plusieurs méthodes HTTP pour le même chemin.

- `array|string $methods` : Un tableau contenant les méthodes HTTP ou une chaîne de caractères contenant les méthodes
  HTTP séparées par un "pipe" `|`.
- `string $path` : Le chemin de la route comme pour les autres méthodes d'ajout de route.
- `callable|string $callback` : La fonction à exécuter lorsque la route est appelée. La valeur peut être une fonction
  anonyme ou une chaîne de caractères qui vous sera utile pour vous.

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

Cette méthode permet de récupérer la route correspondante au chemin et à la méthode HTTP. Si aucune route n'est
trouvée, la valeur `null` est retournée.

- `string $path` : Le chemin à matcher.
- `string $method` : La méthode HTTP à matcher.

Pour récupérer les informations des paramètres de la route, vous pouvez utiliser les méthodes de la classe
`Request` ([voir ici](./request)).

**Exemple : route match l'URL**

```php
$router = new AlteRouter\Alterouter();
$router->get('/path', function() {
    echo 'Hello World !';
}, 'route-name');

$route = $router->match('/path', 'GET');
var_dump($route->getName()); // string(10) "route-name"
```

**Exemple : route ne match pas l'URL**

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

Cette méthode permet de générer une URL à partir du nom de la route et des paramètres. Si la route n'est pas trouvée,
une exception est levée.

- `string $name` : Le nom de la route.
- `array $params = []` : Les paramètres de la route. Il faut indiquer les paramètres dans un tableau associatif avec
  comme clé le nom du paramètre et comme valeur la valeur du paramètre. Si vous indiquez un paramètre qui n'existe pas
  dans la route, alors il est ajouté à la fin de l'URL en tant que paramètre GET `?key=value&key2=value2`.

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
