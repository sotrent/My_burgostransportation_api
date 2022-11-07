<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require '../vendor/autoload.php';

$app = new \Slim\Slim();

require __DIR__ . '/../src/middleware.php';
require __DIR__ . '/../src/routes.php';
$app->run();
