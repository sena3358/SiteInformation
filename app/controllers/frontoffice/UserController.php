<?php

declare(strict_types=1);

require_once __DIR__ . '/../../models/User.php';

final class UserController
{
    public static function list(): void
    {
        $users = User::all();
        require __DIR__ . '/../../views/frontoffice/user/list.php';
    }

    public static function form(): void
    {
        require __DIR__ . '/../../views/frontoffice/user/form.php';
    }
}
