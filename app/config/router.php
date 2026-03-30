<?php

declare(strict_types=1);

/**
 * @param array<int,array{method:string,pattern:string,handler:callable|string|array{0:string,1:string}}> $routes
 * @param callable|string|array{0:string,1:string} $handler
 */
function app_add_route(array &$routes, string $method, string $pattern, $handler): void
{
    $routes[] = [
        'method' => strtoupper($method),
        'pattern' => $pattern,
        'handler' => $handler,
    ];
}

/**
 * @param array<int,array{method:string,pattern:string,handler:callable|string|array{0:string,1:string}}> $routes
 */
function app_dispatch(array $routes): void
{
    $method = strtoupper($_SERVER['REQUEST_METHOD'] ?? 'GET');
    $path = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
    $path = is_string($path) && $path !== '' ? $path : '/';
    $path = '/' . trim($path, '/');
    if ($path === '//') {
        $path = '/';
    }

    foreach ($routes as $route) {
        if ($route['method'] !== $method) {
            continue;
        }

        $pattern = '/' . trim($route['pattern'], '/');
        if ($pattern === '//') {
            $pattern = '/';
        }

        $regex = '#^' . preg_replace('#@([a-zA-Z_][a-zA-Z0-9_]*)#', '([^/]+)', preg_quote($pattern, '#')) . '/?$#';
        $regex = str_replace('\\(\[\^/\]\+\\)', '([^/]+)', $regex);

        if (!preg_match($regex, $path, $matches)) {
            continue;
        }

        array_shift($matches);

        $handler = $route['handler'];
        if (is_array($handler) && count($handler) === 2) {
            [$class, $methodName] = $handler;
            $class::$methodName(...$matches);
            return;
        }

        if (is_callable($handler)) {
            $handler(...$matches);
            return;
        }
    }

    app_halt(404, 'Page introuvable.');
}
