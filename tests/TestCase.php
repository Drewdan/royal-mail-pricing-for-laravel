<?php

namespace Drewdan\RoyalMailPricing\Tests;

use Drewdan\RoyalMailPricing\RoyalMailPricingServiceProvider;

class TestCase extends \Orchestra\Testbench\TestCase {

	public function setUp(): void {
		parent::setUp();
		// additional setup
	}

	protected function getPackageProviders($app): array {
		return [
			RoyalMailPricingServiceProvider::class
		];
	}

	protected function getEnvironmentSetUp($app) {
		// perform environment setup
	}
}
