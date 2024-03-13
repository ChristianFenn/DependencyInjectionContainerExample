<?php

require_once 'vendor/autoload.php';

use App\DependencyInjection\Container as DependencyInjectionContainer;
use App\Services\OrderService;

$container = new DependencyInjectionContainer();
$orderService = $container->resolve(OrderService::class);
$orderService->process();
