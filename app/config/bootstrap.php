<?php

declare(strict_types=1);

require_once __DIR__ . '/database.php';

function app_set_status(int $statusCode): void
{
    http_response_code($statusCode);
}

function app_set_header(string $name, string $value): void
{
    header($name . ': ' . $value);
}

function app_redirect(string $path, int $statusCode = 302): void
{
    app_set_status($statusCode);
    app_set_header('Location', $path);
    exit;
}

/** @param array<string,mixed> $payload */
function app_json(array $payload, int $statusCode = 200): void
{
    app_set_status($statusCode);
    app_set_header('Content-Type', 'application/json; charset=UTF-8');
    echo json_encode($payload, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
}

function app_halt(int $statusCode, string $message): void
{
    app_set_status($statusCode);
    app_set_header('Content-Type', 'text/plain; charset=UTF-8');
    echo $message;
    exit;
}

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
