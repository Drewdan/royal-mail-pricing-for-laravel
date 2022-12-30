<?php

namespace Drewdan\RoyalMailPricing\Tests\Unit;

use Drewdan\RoyalMailPricing\Models\Item;
use Drewdan\RoyalMailPricing\Consignment;
use Drewdan\RoyalMailPricing\Tests\TestCase;
use Drewdan\RoyalMailPricing\Models\ParcelSize;
use Drewdan\RoyalMailPricing\Exceptions\NoSuitablePackageForItemException;

class ConsignmentTest extends TestCase {

	public function testSingleItemCanBeAssignedToParcelAndGetsAssignedToAMediumParcel() {

		$item = Item::make()
			->setName('Test Item 1')
			->setWeight(2101)
			->setHeight(10)
			->setWidth(10)
			->setLength(10);

		$consignment = Consignment::make()
			->addItem($item)
			->assignToParcels()
			->getConsignment();

		$parcels = $consignment->getParcels();

		$this->assertCount(1, $parcels);

		$parcel = $parcels[0];
		$price = $parcel->price;

		$this->assertEquals(ParcelSize::MediumParcel, $parcel->size);
		$this->assertEquals(2101, $parcel->weight);

		$this->assertEquals(7.95, $price->firstClassPostage);
		$this->assertEquals(6.95, $price->secondClassPostage);
		$this->assertEquals(10000, $price->weight);

		$this->assertEquals(1, $consignment->getParcelCount());
		$this->assertEquals(1, $consignment->getItemCount());
		$this->assertEquals(7.95, $consignment->getPostageCost());
		$this->assertEquals(6.95, $consignment->getPostageCost('secondClassPostage'));
	}

	public function testTwoItemsCanBeAssignedToParcelAndGetsAssignedToAMediumParcel() {
		$item1 = Item::make()
			->setName('Test Item 1')
			->setWeight(2101)
			->setHeight(10)
			->setWidth(10)
			->setLength(10);
		$item2 = Item::make()
			->setName('Test Item 2')
			->setWeight(2101)
			->setHeight(10)
			->setWidth(10)
			->setLength(10);

		$consignment = Consignment::make()
			->addItem($item1)
			->addItem($item2)
			->assignToParcels()
			->getConsignment();

		$parcels = $consignment->getParcels();

		$this->assertCount(1, $parcels);

		$parcel = $parcels[0];
		$price = $parcel->price;

		$this->assertEquals(ParcelSize::MediumParcel, $parcel->size);
		$this->assertEquals(4202, $parcel->weight);

		$this->assertEquals(7.95, $price->firstClassPostage);
		$this->assertEquals(6.95, $price->secondClassPostage);
		$this->assertEquals(10000, $price->weight);
	}

	public function testItemsCanBeSpreadAmongstManyParcels() {
		$items = [];

		for($i = 0, $j = 1; $i < 10; $i++, $j++) {
			$items[] = Item::make()
				->setName('Test Item ' . $j)
				->setWeight(2500)
				->setHeight(10)
				->setWidth(10)
				->setLength(10);
		}

		$consignment = Consignment::make()
			->addItems($items)
			->assignToParcels()
			->getConsignment();

		$this->assertEquals(3, $consignment->getParcelCount());
		$this->assertEquals(10, $consignment->getItemCount());
		$this->assertEquals(23.85, $consignment->getPostageCost());
		$this->assertEquals(20.85, $consignment->getPostageCost('secondClassPostage'));
	}

	public function testExceptionThrownWhenParcelCannotBeCarriedByRoyalMail() {
		$this->expectException(NoSuitablePackageForItemException::class);

		// The max height for a parcel is 46cm
		$item = Item::make()
			->setName('Test Item 1')
			->setWeight(2101)
			->setHeight(500)
			->setWidth(10)
			->setLength(10);

		Consignment::make()->addItem($item)->assignToParcels()->getConsignment();
	}

}
