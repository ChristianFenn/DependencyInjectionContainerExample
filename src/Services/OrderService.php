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
		$receiptId = $this->paymentService->processPayment();
		$this->customerEngagementService->sendEmail();
		return new OrderReceipt($receiptId);
	}
}
