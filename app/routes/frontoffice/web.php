<?php

declare(strict_types=1);

require_once __DIR__ . '/../../controllers/frontoffice/HomeController.php';
require_once __DIR__ . '/../../controllers/frontoffice/FrontArticleController.php';
require_once __DIR__ . '/../../controllers/frontoffice/UserController.php';
require_once __DIR__ . '/../../controllers/frontoffice/VisitorAuthController.php';

Flight::route('GET /mvc', [HomeController::class, 'index']);
Flight::route('GET /article/@id', [FrontArticleController::class, 'show']);
Flight::route('GET /categorie/@id', [FrontArticleController::class, 'byCategory']);
Flight::route('GET /users', [UserController::class, 'list']);
Flight::route('GET /users/form', [UserController::class, 'form']);
Flight::route('GET /login', [VisitorAuthController::class, 'loginForm']);
Flight::route('POST /login', [VisitorAuthController::class, 'login']);
Flight::route('GET /logout', [VisitorAuthController::class, 'logout']);
Flight::route('GET /mon-compte', [VisitorAuthController::class, 'account']);
