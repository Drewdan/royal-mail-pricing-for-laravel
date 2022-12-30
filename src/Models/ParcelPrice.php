<?php

namespace Drewdan\RoyalMailPricing\Models;

class ParcelPrice {

	public float $weight;

	public float $firstClassPostage;

	public float $secondClassPostage;

	public function __construct(float $weight, float $firstClassPostage, float $secondClassPostage) {
		$this->weight = $weight;
		$this->firstClassPostage = $firstClassPostage;
		$this->secondClassPostage = $secondClassPostage;
	}
}
