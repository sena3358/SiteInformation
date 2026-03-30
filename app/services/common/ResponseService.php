<?php

declare(strict_types=1);

final class ResponseService
{
    public static function redirect(string $path): void
    {
        app_redirect($path, 302);
    }
}
