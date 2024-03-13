<?php

require_once 'vendor/autoload.php';

use App\Services\OrderService;

use App\Services\CustomerEngagementService;
use App\Services\PaymentService;
use App\Services\SecurityClient;

$orderService = new OrderService(
    new PaymentService(new SecurityClient()),
    new CustomerEngagementService()
);

$orderService->process();
