<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Router\RouteResolver;

$router = new RouteResolver;
$router->resolve($_SERVER['REQUEST_URI']);
