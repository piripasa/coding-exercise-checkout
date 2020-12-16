<?php

require_once 'vendor/autoload.php';

use App\Entities\Item;
use App\Repositories\RulesRepository;
use App\Rules\BundlePriceRule;
use App\Services\Checkout;

$items = [
    'A' => new Item('A', 50),
    'B' => new Item('B', 30),
    'C' => new Item('C', 20),
    'D' => new Item('D', 15),
];

$priceRuleList = [
    'A' => [
        'count' => 3,
        'price' => 130,
    ],
    'B' => [
        'count' => 2,
        'price' => 45,
    ]
];

$rulesRepository = new RulesRepository();
$rulesRepository->add(new BundlePriceRule($priceRuleList));

$co = new Checkout($rulesRepository);

echo "Scan 1 product (A) ".PHP_EOL;
$co->scan($items['A']);
echo "Scan 2 product (A)".PHP_EOL;
$co->scan($items['A']);
echo "Scan 3 product (A)".PHP_EOL;
$co->scan($items['A']);
echo "Scan 4 product (A)".PHP_EOL;
$co->scan($items['A']);
echo "The total price: ".$co->total().PHP_EOL;
echo "Actual price: ".$co->getCart()->subTotal().PHP_EOL;
