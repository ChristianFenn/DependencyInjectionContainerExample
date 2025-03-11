<?php

namespace App\Services;

class PaymentService
{

	public function __construct(SecurityClient $securityClient)
	{
		// fake dependency PaymentService requires
	}

	public function processPayment(): string
	{
		// AWS API 0.001 USD
		sleep(2);
		return "123"; // some kind of fake receipt ID
	}
}
