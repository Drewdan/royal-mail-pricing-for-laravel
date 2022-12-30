<?php

namespace Drewdan\RoyalMailPricing;

use Illuminate\Support\ServiceProvider;

class RoyalMailPricingServiceProvider extends ServiceProvider {

	public function register() {
		$this->mergeConfigFrom(__DIR__ . '/../config/royal-mail-pricing.php', 'royal-mail-pricing');

	}

	public function boot() {
		if ($this->app->runningInConsole()) {

    $this->publishes([
      __DIR__.'/../config/royal-mail-pricing.php' => config_path('royal-mail-pricing.php'),
    ], 'config');

  }
	}
}
