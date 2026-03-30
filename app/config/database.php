<?php

declare(strict_types=1);

require_once __DIR__ . '/../services/common/DatabaseService.php';

function db(): PDO
{
    return DatabaseService::connection();
}
