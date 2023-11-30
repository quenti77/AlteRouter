# PathParameterAliasRegex

Cette classe permet de créer des alias pour les paramètres de routes. Cela permet de simplifier l'écriture des
expressions régulières et de les rendre plus lisibles.

## Sommaire

[[toc]]

## getAlias

```php
/** @return array<string, string> */
PathParameterAliasRegex::getAlias(): array
```

Récupère un tableau associatif avec comme clé le nom de l'alias et comme valeur l'expression régulière de l'alias.

```php
$regex = new PathParameterAliasRegex();
var_dump($regex->getAlias()); // default aliases array
```

## addAlias

```php
PathParameterAliasRegex::addAlias(string $alias, string $regex): void
```

Ajoute un alias à la liste des alias.

- `string $alias` : Le nom de l'alias.
- `string $regex` : L'expression régulière de l'alias.

```php
$regex = new PathParameterAliasRegex();
$regex->addAlias('uuid', '[a-f0-9]{8}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{12}');
var_dump($regex->getAlias()); // default aliases array + uuid alias
```
