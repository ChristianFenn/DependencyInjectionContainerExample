<?php

use App\Services\CustomerEngagementService;
use App\Services\OrderService;
use App\Services\PaymentService;
use App\Services\SecurityClient;
use PHPUnit\Framework\TestCase;

class OrderServiceTest extends TestCase
{

	/**
	 * @throws \PHPUnit\Framework\MockObject\Exception
	 */
	public function testOrderServiceWithMocks()
	{
		$mockPaymentService = $this->createMock(PaymentService::class);
		$mockCustomerEngagementService = $this->createMock(CustomerEngagementService::class);
		$orderService = new OrderService($mockPaymentService, $mockCustomerEngagementService);

		$mockPaymentService->method('processPayment')->willReturn('098');

		$orderService = $orderService->process();
		$id = $orderService->getId();
		$this->assertSame($id, '098');
	}

	public function testOrderServiceWithoutMocks()
	{
		$securityClient = new SecurityClient();
		$paymentService = new PaymentService($securityClient);
		$customerEngagementService = new CustomerEngagementService();

		$orderService = new OrderService($paymentService, $customerEngagementService);

		$orderService = $orderService->process();

		$id = $orderService->getId();
		$this->assertSame($id, '123');
	}
}
