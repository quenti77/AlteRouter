# Changelog

[[toc]]

## 0.1.2

Add a check on the method of a route.

### Add

- Exception message if the HTTP method passed to the constructor of the `AlteRouter\Route` class is not valid.

### Modifications

- Convert to public the constant `AlteRouter\AlteRouter::METHODS`.

## 0.1.1

Fix after test of version 0.1.0.

### Updates

- Move the method `addMultipleMethodRoutes` of the class `AlteRouter\Alterouter` for a more logical location.

### Deletes

- Method `getPathParameterAliasRegex` in the class `AlteRouter\AlteRouter`.

## 0.1.0

Create the project. Add in packagist.

### Add

- Class `AlteRouter\Alterouter`.
- Class `AlteRouter\Route`.
- Class `AlteRouter\PathParameterAliasRegex`.
- Class `AlteRouter\Request`.

### Tests

- Add unit test for class `AlteRouter\Alterouter`.
- Add unit test for class `AlteRouter\Route`.
- Add unit test for class `AlteRouter\PathParameterAliasRegex`.
