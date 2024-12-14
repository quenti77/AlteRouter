# Guide de démarrage

## Prérequis

- Avoir installé PHP 8.2 ou supérieur.
- Avoir installé Composer.

## Installation

À l'aide de votre terminal, rendez-vous dans le dossier de votre projet et exécutez la commande suivante :

```bash
composer require quenti77/alterouter
```

Si ce n'est pas déjà fait, ajoutez dans votre fichier php le code suivant :

```php
// Changez le chemin en fonction de votre projet
require __DIR__ . '/vendor/autoload.php';
```

## Utilisation

### Création d'un routeur

Pour créer un routeur, il suffit d'instancier la classe `AlteRouter\Alterouter` :

```php
$router = new AlteRouter\Alterouter();
```

Si votre projet est dans un sous-dossier, il faut préciser le chemin de ce sous-dossier :

```php
$router = new AlteRouter\Alterouter('/sous-dossier');
```

### Création d'une route

Pour créer une route, il existe plusieurs méthodes :

```php
// Création d'une route avec la méthode générique
$router->addRoute('GET', '/path', function() {
    echo 'Hello World !';
}, 'route-name');
```

Voici les paramètres de la méthode `addRoute` :

- `string $method` : La méthode HTTP de la route. Les méthodes disponibles
  sont : `GET`, `POST`, `PUT`, `PATCH`, `DELETE`, `HEAD`, `OPTIONS`.
- `string $path` : Le chemin de la route. Les chemins peuvent contenir des paramètres. Les paramètres sont préfixés
  d'accolades. Exemple : `/path/{id}`.
- `callable|string $callback` : La fonction à exécuter lorsque la route est appelée. La valeur peut être une fonction
  anonyme ou une chaîne de caractères qui vous sera utile pour vous.
- `string $name = null` : Le nom de la route. Ce paramètre est optionnel.


```php
// Création d'une route avec la méthode GET
$router->get('/path', function() {
    echo 'Hello World !';
}, 'route-name');
```

Contrairement à la méthode `addRoute`, la méthode `get` ne prend pas en paramètre la méthode HTTP de la route, car
cette méthode est spécifique à la méthode `GET`.

Il existe une méthode pour chaque méthode HTTP : `get`, `post`, `put`, `patch`, `delete`, `head`, `options`.

### Match d'une route

Pour matcher une route, il suffit d'appeler la méthode `match` avec la méthode HTTP et l'URL de la route. Vous
pouvez vous aider de la classe `AlteRouter\Request` pour récupérer la méthode HTTP et l'URL de la route.

```php
$route = $router->match(AlteRouter\Request::getMethodFromGlobals(), AlteRouter\Request::getPathFromGlobals());
```

Si la route n'est pas trouvée, la méthode `match` retourne `null`. Sinon, elle retourne un objet `AlteRouter\Route`.

### Exécution d'une route

En fonction de si la route trouvée à un handler avec une fonction anonyme ou une chaîne de caractères, vous
devez exécuter la route différemment. Voici un exemple :

```php
$route = $router->match(AlteRouter\Request::getMethodFromGlobals(), AlteRouter\Request::getPathFromGlobals());

if ($route !== null) {
    if (is_string($route->getHandler())) {
        [$controller, $method] = explode('@', $route->getHandler());
        $controller = new $controller();
        $controller->$method($route->getMatches());
    } else {
        call_user_func_array($route->getHandler(), $route->getMatches());
    }
}
```

Ceci est un exemple simple pour vous montrer comment exécuter une route. Vous pouvez coder votre propre système.