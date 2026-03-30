<?php

declare(strict_types=1);

require_once __DIR__ . '/database.php';

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

Flight::set('flight.log_errors', true);
