<?php

declare(strict_types=1);

final class ResponseService
{
    public static function redirect(string $path): void
    {
        Flight::response()->status(302);
        header('Location: ' . $path);
        exit;
    }
}
