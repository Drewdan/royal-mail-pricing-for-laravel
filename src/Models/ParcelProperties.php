<?php

namespace Drewdan\RoyalMailPricing\Models;

class ParcelProperties {

	public float $weight;
	public float $length;
	public float $width;
	public float $height;

	public array $prices = [];

	public function __construct(float $weight, float $length, float $width, float $height, array $prices) {
		$this->weight = $weight;
		$this->length = $length;
		$this->width = $width;
		$this->height = $height;
		$this->prices = $prices;
	}

}
