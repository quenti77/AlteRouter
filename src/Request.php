<?php

namespace Alterouter;

use InvalidArgumentException;

class Request
{
    public static function getMethodFromGlobals(): string
    {
        return strtoupper($_SERVER['REQUEST_METHOD'] ?? 'GET');
    }

    public static function getPathFromGlobals(): string
    {
        $path = $_SERVER['REQUEST_URI'] ?? '/';
        $path = parse_url($path, PHP_URL_PATH);

        if (!is_string($path)) {
            throw new InvalidArgumentException('Invalid path');
        }
        return rawurldecode($path);
    }
}
