<?php

require_once 'vendor/autoload.php';

use App\DependencyInjection\Container as DependencyInjectionContainer;
use App\Services\OrderService;

use App\Services\CustomerEngagementService;
use App\Services\PaymentService;
use App\Services\SecurityClient;

$container = new DependencyInjectionContainer();

$container->set(PaymentService::class, function (DependencyInjectionContainer $container) {
    return new PaymentService($container->get(SecurityClient::class));
});

$container->set(SecurityClient::class, function () {
    return new SecurityClient();
});

$container->set(CustomerEngagementService::class, function () {
    return new CustomerEngagementService();
});

$container->set(
    OrderService::class,
    function (DependencyInjectionContainer $container) {
        return new OrderService(
            $container->get(PaymentService::class),
            $container->get(CustomerEngagementService::class)
        );
    }
);

$orderService = $container->get(OrderService::class);

$orderService->process();
