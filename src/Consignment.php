<?php

namespace Drewdan\RoyalMailPricing;

use Illuminate\Support\Collection;
use Drewdan\RoyalMailPricing\Models\Item;
use Drewdan\RoyalMailPricing\Models\Parcel;
use Drewdan\RoyalMailPricing\Models\ParcelSize;

class Consignment {

	public Collection $items;

	public Collection $parcels;

	public float $firstClassPostage = 0;

	public float $secondClassPostage = 0;

	public float $consignmentWeight = 0;

	public int $parcelCount = 0;

	public int $itemCount = 0;


	public function __construct() {
		$this->items = collect();
		$this->parcels = collect();
	}


	public function addItem(Item $item): Consignment {
		$this->items->push($item);

		return $this;
	}

	public function addItems(Collection|array $items): Consignment {
		$this->items->push(...$items);

		return $this;
	}

	public function assignToParcels(): Consignment {
		if ($this->items->count() === 0) {
			throw new \Exception(
				'No items to assign to parcels. Please first add some items to the consignment.'
			);
		}

		$this->parcels =  $this->items->chunkWhile(function ($value, $key, $chunk) {
			$chunkToCheck = $chunk->all();
			$chunkToCheck = collect($chunkToCheck)->push($value);
			return !!$this->findSuitablePackage($chunkToCheck);
		})->map(function ($chunk) {
			$package = $this->findSuitablePackage($chunk);

			if (!$package) {
				throw new \Drewdan\RoyalMailPricing\Exceptions\NoSuitablePackageForItemException(
					'Could not find a suitable package for the items in the consignment.'
				);
			}

			return new Parcel($package, $chunk);
		});

		return $this;
	}

	public function getConsignment(): Consignment {
		$this->firstClassPostage = $this->parcels->sum('price.firstClassPostage');
		$this->secondClassPostage = $this->parcels->sum('price.secondClassPostage');
		$this->consignmentWeight = $this->parcels->sum('weight');
		$this->parcelCount = $this->parcels->count();
		$this->itemCount = $this->items->count();

		return $this;
	}

	public function getParcels(): Collection {
		return $this->parcels;
	}

	public function getPostageCost(string $postageType = 'firstClassPostage'): float {
		return $this->$postageType;
	}

	public function getConsignmentWeight(): float {
		return $this->consignmentWeight;
	}

	public function getParcelCount(): int {
		return $this->parcelCount;
	}

	public function getItemCount(): int {
		return $this->itemCount;
	}

	private function findSuitablePackage(Collection $items): ?ParcelSize {
		$totalWeight = $items->sum('weight');
		$totalHeight = $items->sum('height');
		$maxWidth = $items->max('width');
		$maxLength = $items->max('length');

		// Firstly find a parcel which can handle the total weight of the order
		$suitablePackages = collect(ParcelSize::cases())->filter(
			fn (ParcelSize $parcelSize) =>
				$parcelSize->properties()->weight >= $totalWeight
				&& $parcelSize->properties()->height >= $totalHeight
				&& $parcelSize->properties()->width >= $maxWidth
				&& $parcelSize->properties()->length >= $maxLength
		);

		return $suitablePackages->first();
	}

	public static function make(): Consignment {
		return new Consignment();
	}
}
