<?php

namespace App\Services;

class OrderService {

    public function __construct(
        PaymentService $paymentService, 
        CustomerEngagementService $customerEngagementService,
        ) {}

    public function process() {
        echo 'Done!' . PHP_EOL;
    }

}
