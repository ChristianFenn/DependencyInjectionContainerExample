<?php

namespace App\Services;

use App\Models\OrderReceipt;

class OrderService
{

	private PaymentService $paymentService;
	private CustomerEngagementService $customerEngagementService;

	public function __construct(PaymentService $paymentService, CustomerEngagementService $customerEngagementService)
	{
		$this->paymentService = $paymentService;
		$this->customerEngagementService = $customerEngagementService;
	}

	public function process(): OrderReceipt
	{
		// All of the logic here will be tested ...
		// ...

		$trackingId = $this->paymentService->processPayment(); // should be mocked
		$this->customerEngagementService->sendEmail(['tracking_id' => $trackingId]); // should be mocked

		// All of the logic here will be tested ...
		return new OrderReceipt('123');
	}
}
