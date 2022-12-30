<?php

namespace Drewdan\RoyalMailPricing\Models;

use Illuminate\Support\Collection;

class Parcel {

	public ParcelSize $size;

	public float $weight;

	public Collection $items;

	public ParcelPrice $price;

	public function __construct(ParcelSize $size, Collection $items) {
		$this->size = $size;
		$this->items = $items;
		$this->calculateWeight();
		$this->calculatePrice();
	}

	private function calculateWeight(): void {
		$this->weight = $this->items->sum('weight');
	}

	private function calculatePrice(): void {
		$this->price = collect($this->size->properties()->prices)
			->filter(fn (ParcelPrice $parcelPrice) => $parcelPrice->weight >= $this->weight)
			->first();

	}
}
