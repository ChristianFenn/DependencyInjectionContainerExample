<?php

namespace App\Services;

class CustomerEngagementService
{

	public function __construct()
	{
	}

	public function sendEmail(array $payload): void
	{
		echo 'CustomerEngagementService sending email...' . PHP_EOL;
		sleep(2);
	}
}
