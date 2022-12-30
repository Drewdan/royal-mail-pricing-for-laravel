<?php

return [
	'config' => [
		'current-pricing-period' => env('ROYAL_MAIL_PRICING_PERIOD', '2022-04'),
	],
	'pricing' => [
		'2022-04' => [
			'standard' => [
				'letter' => [
					'weight' => 100,
					'length' => 24,
					'width' => 16.5,
					'height' => 0.5,
					'prices' => [
						[
							'weight' => 100,
							'firstClassPostage' => 0.95,
							'secondClassPostage' => 0.68,
						],
					],
				],
				'largeLetter' => [
					'weight' => 750,
					'length' => 35.3,
					'width' => 25,
					'height' => 2.5,
					'prices' => [
						[
							'weight' => 100,
							'firstClassPostage' => 1.45,
							'secondClassPostage' => 1.05,
						],
						[
							'weight' => 250,
							'firstClassPostage' => 2.05,
							'secondClassPostage' => 1.65,
						],
						[
							'weight' => 500,
							'firstClassPostage' => 2.65,
							'secondClassPostage' => 2.15,
						],
						[
							'weight' => 750,
							'firstClassPostage' => 3.30,
							'secondClassPostage' => 2.70,
						],
					],
				],
				'smallParcel' => [
					'weight' => 2000,
					'length' => 45,
					'width' => 35,
					'height' => 16,
					'prices' => [
						[
							'weight' => 2000,
							'firstClassPostage' => 4.45,
							'secondClassPostage' => 3.35,
						],
					],
				],
				'mediumParcel' => [
					'weight' => 20000,
					'length' => 61,
					'width' => 46,
					'height' => 46,
					'prices' => [
						[
							'weight' => 2000,
							'firstClassPostage' => 6.95,
							'secondClassPostage' => 5.35,
						],
						[
							'weight' => 10000,
							'firstClassPostage' => 7.95,
							'secondClassPostage' => 6.95,
						],
						[
							'weight' => 20000,
							'firstClassPostage' => 12.95,
							'secondClassPostage' => 10.45,
						],
					],
				],
			],
		],
	],
];
