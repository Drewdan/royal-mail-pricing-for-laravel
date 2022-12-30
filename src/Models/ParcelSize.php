<?php

namespace Drewdan\RoyalMailPricing\Models;

enum ParcelSize {
	case Letter;
	case LargeLetter;
	case SmallParcel;
	case MediumParcel;

	public function properties(): ParcelProperties {
		$pricingPeriod = config('royal-mail-pricing.config.current-pricing-period');

		$prices = config('royal-mail-pricing.pricing.' . $pricingPeriod . '.standard');

		// TODO: Refactor this

		$letterPrices = [];
		$largeLetterPrices = [];
		$smallParcelPrices = [];
		$mediumParcelPrices = [];

		foreach($prices['letter']['prices'] as $price) {
			$letterPrices[] = new ParcelPrice(
				$price['weight'],
				$price['firstClassPostage'],
				$price['secondClassPostage']
			);
		}

		foreach($prices['largeLetter']['prices'] as $price) {
			$largeLetterPrices[] = new ParcelPrice(
				$price['weight'],
				$price['firstClassPostage'],
				$price['secondClassPostage']
			);
		}

		foreach($prices['smallParcel']['prices'] as $price) {
			$smallParcelPrices[] = new ParcelPrice(
				$price['weight'],
				$price['firstClassPostage'],
				$price['secondClassPostage']
			);
		}

		foreach($prices['mediumParcel']['prices'] as $price) {
			$mediumParcelPrices[] = new ParcelPrice(
				$price['weight'],
				$price['firstClassPostage'],
				$price['secondClassPostage']
			);
		}


		return match($this) {
			ParcelSize::Letter => new ParcelProperties(
				$prices['letter']['weight'],
				$prices['letter']['length'],
				$prices['letter']['width'],
				$prices['letter']['height'],
				$letterPrices,
			),
			ParcelSize::LargeLetter => new ParcelProperties(
				$prices['largeLetter']['weight'],
				$prices['largeLetter']['length'],
				$prices['largeLetter']['width'],
				$prices['largeLetter']['height'],
				$largeLetterPrices,
			),
			ParcelSize::SmallParcel => new ParcelProperties(
				$prices['smallParcel']['weight'],
				$prices['smallParcel']['length'],
				$prices['smallParcel']['width'],
				$prices['smallParcel']['height'],
				[
					new ParcelPrice(2000, 4.45, 3.35),
				]
			),
			ParcelSize::MediumParcel => new ParcelProperties(
				$prices['mediumParcel']['weight'],
				$prices['mediumParcel']['length'],
				$prices['mediumParcel']['width'],
				$prices['mediumParcel']['height'],
				$mediumParcelPrices,
			),
		};
	}
}
