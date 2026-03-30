<?php

declare(strict_types=1);

require_once __DIR__ . '/AuthService.php';

final class ViewService
{
    /** @param array<string,mixed> $data */
    public static function render(string $title, string $view, array $data = []): void
    {
        $viewFile = __DIR__ . '/../../views/backoffice/' . $view . '.php';
        if (!is_file($viewFile)) {
            throw new RuntimeException('Vue introuvable: ' . $view);
        }

        extract($data, EXTR_SKIP);
        $flash = AuthService::popFlash();

        ob_start();
        require $viewFile;
        $content = (string) ob_get_clean();

        Flight::response()->header('Content-Type', 'text/html; charset=UTF-8');
        require __DIR__ . '/../../views/backoffice/layouts/admin.php';
    }

    public static function e(string $value): string
    {
        return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
    }
}
