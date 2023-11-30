# PathParameterAliasRegex

This class allows you to create aliases for route parameters. This makes it easier to write regular expressions and
makes them more readable.

## Table of contents

[[toc]]

## getAlias

```php
/** @return array<string, string> */
PathParameterAliasRegex::getAlias(): array
```

Get an associative array with the alias name as key and the alias regular expression as value.

```php
$regex = new PathParameterAliasRegex();
var_dump($regex->getAlias()); // default aliases array
```

## addAlias

```php
PathParameterAliasRegex::addAlias(string $alias, string $regex): void
```

Add an alias to the list of aliases.

- `string $alias` : The name of the alias.
- `string $regex` : The regular expression of the alias.

```php
$regex = new PathParameterAliasRegex();
$regex->addAlias('uuid', '[a-f0-9]{8}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{12}');
var_dump($regex->getAlias()); // default aliases array + uuid alias
```
