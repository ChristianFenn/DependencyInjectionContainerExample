<?php

use App\Services\CustomerEngagementService;
use App\Services\OrderService;
use App\Services\PaymentService;
use App\Services\SecurityClient;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\MockObject\MockObject;

class OrderServiceTest extends TestCase
{

	/**
	 * @throws \PHPUnit\Framework\MockObject\Exception
	 */
	public function testOrderServiceWithMocks()
	{
		// Note the intersection type hints

		/** @var MockObject&PaymentService */
		$mockPaymentService = $this->createMock(PaymentService::class);

		/** @var MockObject&CustomerEngagementService */
		$mockCustomerEngagementService = $this->createMock(CustomerEngagementService::class);
		
		$orderService = new OrderService($mockPaymentService, $mockCustomerEngagementService);

		$mockPaymentService->method('processPayment')->willReturn('098');

		$orderReceipt = $orderService->process();
		$id = $orderReceipt->getId();
		$this->assertSame($id, '123');
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
