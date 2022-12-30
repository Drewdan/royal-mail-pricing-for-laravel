# Royal Mail Pricing

Royal Mail Pricing is a small package for Laravel 9+ which allows you to create items, which have dimensions and weights,
and then calculate the amount of Royal Mail packages you would need to send them all, giving you a price for
First and Second class standard postage.

I created this package as the Royal Mail API does not seem to include an easy way to calculate pricing for packages
and I also wanted to automate the allocation of items to parcels. I have not included the ability to calculate
pricing for services other than the standard Royal Mail first and second class services. I may implement this in
future if there is demand for it. Alternatively, I'd welcome a pull request to expand this functionality.

## Installation

Install the package using composer with the following command:

```bash
composer require drewdan/royal-mail-pricing
```

## Configuration

The pricing for Royal Mail is based on the weight and dimensions of the items you are sending. You can configure
the pricing for each of these in the config file. To publish the config file, run the following command:

```bash
php artisan vendor:publish --provider="Drewdan\RoyalMailPricing\RoyalMailPricingServiceProvider" --tag="config"
````

The pricing details are versioned by date to make it easier for me to add new pricing structures in the future. The
default pricing details can be found in the `config/royal-mail-pricing.php` file. If you wish to add a new pricing
structure, you can do so by adding a new array to the `pricing` array in the config file and then updating the 
`current-pricing-period` to be the key you added. This can be overridden in your env file by adding the following
key: `ROYAL_MAIL_PRICING_PERIOD=`

## Usage

Firstly create one or more items which have a name, weight and dimensions:

```php
use Drewdan\RoyalMailPricing\Models\Item;

$item = Item::make()
    ->setName('Test Item 1')
    ->setWeight(2101)
    ->setHeight(10)
    ->setWidth(10)
    ->setLength(10);
```

The weight entered is in grams and the size is a float in centimetres.

Then you can create a new Consignment and add the items to it:

```php
use Drewdan\RoyalMailPricing\Consignment;

$consignment = Consignment::make()
    ->addItem($item)
    ->assignToParcels()
    ->getConsignment();
```

If you want to add multiple items at once, you may either change the `addItem` method to `addItems` and pass an array or
Collection of items, or just loop through your array and call addItem for each item.

When you call get consignment, you will be returned an instance of the Consignment class, which has a number of methods
which you can use to get details about the consignment.

```php

$consignment->getPostageCost('firstClassPostage'); // Returns the price of the consignment for first class postage
$consignment->getPostageCost('secondClassPostage'); // Returns the price of the consignment for second class postage
$consignment->getParcels(); // Returns an array of parcels which make up the consignment
$consignment->getConsignmentWeight(); // Returns the total weight of the consignment
$consignment->getParcelCount(); // Returns the number of parcels in the consignment
$consignment->getItemCount(); // Returns the number of items in the consignment
```

If you try to call `->assignToParcels()` without first adding items, an exception will be thrown.

Calling `->assignToParcels()` will try to find the smallest amount of parcels possible to fit all the items in, and will
then assign the items to the parcels. If it cannot fit all the items in at once, it will chunk the items and look for a
suitable package until all items have been assigned to a package.

If the system cannot find an appropriate package for an item, an exception will be thrown.

**Note:** The Royal Mail API does not include a way to calculate the price of a parcel, so I have had to hard code the
prices into the package. These prices are correct as of 2022-04-01. If you find that the prices are incorrect, please
raise an issue and I will update them. I will endeavour to keep them up to date, but I cannot guarantee that they will
always be correct.

**Warning:** This package is not affiliated with Royal Mail in any way. I have tried my best to make this as accurate as
possible in terms of allocating items to packages based on dimensions and weight, and also calculating the price of
the consignment. However, I cannot guarantee that the prices are correct, or that the package allocation is correct.
You should do your own testing to ensure this package suits your needs and that the prices are correct for your
items. I recommend adding additional postage on top to account for any errors in the calculations.


## Contributing

Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.

Please make sure to update tests as appropriate.

## License

[MIT](https://choosealicense.com/licenses/mit/)
