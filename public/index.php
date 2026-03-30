<?php

declare(strict_types=1);

$autoloadCandidates = [
	__DIR__ . '/../vendor/autoload.php',
	__DIR__ . '/../app/vendor/autoload.php',
];

$autoloadLoaded = false;
foreach ($autoloadCandidates as $autoloadPath) {
	if (is_file($autoloadPath)) {
		require $autoloadPath;
		$autoloadLoaded = true;
		break;
	}
}

if (!$autoloadLoaded) {
	throw new RuntimeException('Impossible de charger vendor/autoload.php');
}

require_once __DIR__ . '/../app/config/bootstrap.php';
require_once __DIR__ . '/../app/routes/backoffice/admin.php';
require_once __DIR__ . '/../app/routes/frontoffice/web.php';

Flight::start();
