<?php

require_once 'vendor/autoload.php';

use App\DependencyInjection\Container as DependencyInjectionContainer;
use App\Services\OrderService;

use App\Services\CustomerEngagementService;
use App\Services\PaymentService;
use App\Services\SecurityClient;

$container = new DependencyInjectionContainer();

// OrderService needs a PaymentService and CustomerEngagementService. It can be instantiated 4th.
$container->set(OrderService::class, fn(DependencyInjectionContainer $c) =>
    new OrderService($c->get(PaymentService::class), $c->get(CustomerEngagementService::class))
);

// PaymentService requires a SecurityClient. Instantiated 3nrd.
$container->set(PaymentService::class, fn(DependencyInjectionContainer $c) => 
    new PaymentService($c->get(SecurityClient::class))
);

// Order of classes with no dependencies does not matter.

// SecurityClient has no dependencies. It can be instantiated 2nd. 
$container->set(SecurityClient::class, fn() => new SecurityClient());

// CustomerEngagementService has no dependencies it can be instantiated 1st.
$container->set(CustomerEngagementService::class, fn() => new CustomerEngagementService());

$orderService = $container->get(OrderService::class);
$orderService->process();
