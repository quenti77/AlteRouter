# Changelog

[[toc]]

## 0.1.2

Ajout d'une vérification sur la méthode d'une route.

### Ajouts

- Exception si la méthode HTTP transmis au constructeur de la classe `AlteRouter\Route` n'est pas valide.

### Modifications

- Rendu public la constante `AlteRouter\AlteRouter::METHODS`.

## 0.1.1

Fix après test de la version 0.1.0.

### Modifications

- Déplacement de la méthode `addMultipleMethodRoutes` de la classe `AlteRouter\Alterouter` pour un emplacement plus
  logique.

### Suppressions

- Méthode `getPathParameterAliasRegex` dans la classe `AlteRouter\AlteRouter`.

## 0.1.0

Création du projet. Ajout dans packagist.

### Ajouts

- Ajout de la classe `AlteRouter\Alterouter`.
- Ajout de la classe `AlteRouter\Route`.
- Ajout de la classe `AlteRouter\PathParameterAliasRegex`.
- Ajout de la classe `AlteRouter\Request`.

### Tests

- Ajout des tests unitaires pour la classe `AlteRouter\Alterouter`.
- Ajout des tests unitaires pour la classe `AlteRouter\Route`.
- Ajout des tests unitaires pour la classe `AlteRouter\PathParameterAliasRegex`.
