<?php


namespace Tests;


use App\Entities\Item;
use App\Repositories\RulesRepository;
use App\Rules\BundlePriceRule;
use App\Rules\CheckoutPriceRule;
use App\Services\Checkout;
use PHPUnit\Framework\TestCase;

class CheckoutTest extends TestCase
{
    private $rulesRepository;
    private $priceRuleList;
    private $items;

    public function setUp()
    {
        parent::setUp();

        $this->rulesRepository = new RulesRepository();

        $this->priceRuleList = [
            'A' => [
                'count' => 3,
                'price' => 130,
            ],
            'B' => [
                'count' => 2,
                'price' => 45,
            ]
        ];

        $this->items = [
            'A' => new Item('A', 50),
            'B' => new Item('B', 30),
            'C' => new Item('C', 20),
            'D' => new Item('D', 15),
        ];
    }

    public function testScanShouldNotAcceptInvalidItem()
    {
        $co = new Checkout($this->rulesRepository);
        $this->expectException(\TypeError::class);
        $co->scan(\stdClass::class);
    }

    public function testScanOnlyAcceptValidItem()
    {
        $co = new Checkout($this->rulesRepository);
        $co->scan(new Item('A', 50));
        $this->assertEquals(50, $co->total());
    }

    public function testScanItems()
    {
        $this->rulesRepository->add(new BundlePriceRule($this->priceRuleList));

        $co = new Checkout($this->rulesRepository);
        $co->scan($this->items['A']);
        $this->assertEquals(50, $co->total());
        $co->scan($this->items['B']);
        $this->assertEquals(80, $co->total());
        $co->scan($this->items['A']);
        $this->assertEquals(130, $co->total());
        $co->scan($this->items['A']);
        $this->assertEquals(160, $co->total());
        $co->scan($this->items['B']);
        $this->assertEquals(175, $co->total());
    }

    public function testCheckoutShouldWorkWithoutRules()
    {
        $co = new Checkout($this->rulesRepository);
        $co->scan($this->items['A']);
        $this->assertEquals(50, $co->total());
        $co->scan($this->items['B']);
        $this->assertEquals(80, $co->total());
        $co->scan($this->items['A']);
        $this->assertEquals(130, $co->total());
        $co->scan($this->items['A']);
        $this->assertEquals(180, $co->total());
        $co->scan($this->items['B']);
        $this->assertEquals(210, $co->total());
    }

    public function testCheckoutOne()
    {
        $this->rulesRepository->add(new BundlePriceRule($this->priceRuleList));

        $co = new Checkout($this->rulesRepository);
        $co->scan($this->items['A']);
        $this->assertEquals(50, $co->total());
        $co->scan($this->items['B']);
        $this->assertEquals(80, $co->total());
    }

    public function testCheckoutTwo()
    {
        $this->rulesRepository->add(new BundlePriceRule($this->priceRuleList));

        $co = new Checkout($this->rulesRepository);
        $co->scan($this->items['A']);
        $this->assertEquals(50, $co->total());
        $co->scan($this->items['A']);
        $this->assertEquals(100, $co->total());
    }

    public function testCheckoutThree()
    {
        $this->rulesRepository->add(new BundlePriceRule($this->priceRuleList));

        $co = new Checkout($this->rulesRepository);
        $co->scan($this->items['A']);
        $this->assertEquals(50, $co->total());
        $co->scan($this->items['A']);
        $this->assertEquals(100, $co->total());
        $co->scan($this->items['A']);
        $this->assertEquals(130, $co->total());
    }

    public function testCheckoutFour()
    {
        $this->rulesRepository->add(new BundlePriceRule($this->priceRuleList));

        $co = new Checkout($this->rulesRepository);
        $co->scan($this->items['A']);
        $this->assertEquals(50, $co->total());
        $co->scan($this->items['B']);
        $this->assertEquals(80, $co->total());
        $co->scan($this->items['C']);
        $this->assertEquals(100, $co->total());
        $co->scan($this->items['D']);
        $this->assertEquals(115, $co->total());
    }

    public function testCheckoutTotalAndCartTotalShouldNotMatchAfterPriceRulesApply()
    {
        $this->rulesRepository->add(new BundlePriceRule($this->priceRuleList));

        $co = new Checkout($this->rulesRepository);
        $co->scan($this->items['A']);
        $this->assertEquals(50, $co->total());
        $co->scan($this->items['A']);
        $this->assertEquals(100, $co->total());
        $co->scan($this->items['A']);
        $this->assertEquals(130, $co->total());
        $this->assertNotEquals(150, $co->total());
        $this->assertEquals(150, $co->getCart()->subTotal());
    }

    public function testCheckoutRuleIfSpendOverSomeAmount()
    {
        $this->rulesRepository->add(new BundlePriceRule($this->priceRuleList));
        $this->rulesRepository->add(new CheckoutPriceRule(200, 10));

        $co = new Checkout($this->rulesRepository);
        $co->scan($this->items['A']);
        $co->scan($this->items['A']);
        $co->scan($this->items['A']);
        $co->scan($this->items['A']);
        $co->scan($this->items['B']);
        $co->scan($this->items['C']);
        $co->scan($this->items['D']);
        $this->assertEquals(220.5, $co->total());
        $this->assertEquals(265, $co->getCart()->subTotal());
    }
}
