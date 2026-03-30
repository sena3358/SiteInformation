<?php

declare(strict_types=1);

require_once __DIR__ . '/../app/config/bootstrap.php';
require_once __DIR__ . '/../app/config/router.php';

$routes = [];
require_once __DIR__ . '/../app/routes/backoffice/admin.php';
require_once __DIR__ . '/../app/routes/frontoffice/web.php';

app_dispatch($routes);
