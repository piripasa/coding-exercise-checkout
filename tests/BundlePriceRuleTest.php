<?php


namespace Tests;


use App\Entities\Item;
use App\Rules\BundlePriceRule;
use App\Services\Cart;
use PHPUnit\Framework\TestCase;

class BundlePriceRuleTest extends TestCase
{
    private $cart;
    private $rule;

    public function setUp()
    {
        parent::setUp();
        $this->cart = new Cart();
        $this->rule = new BundlePriceRule([
            'A' => [
                'count' => 3,
                'price' => 130,
            ]
        ]);
    }

    public function testParamShouldNotNull()
    {
        $this->expectException(\TypeError::class);
        new BundlePriceRule(null);
    }

    public function testParamShouldNotNonArray()
    {
        $this->expectException(\TypeError::class);
        new BundlePriceRule('nonarray');
    }

    public function testCalculateTotalOnlyAcceptValidCart()
    {
        $this->assertEquals(0, $this->rule->calculateTotal($this->cart));
    }

    public function testRuleSuccess()
    {
        $this->cart->addItem(new Item('A', 50));
        $this->cart->addItem(new Item('A', 50));
        $this->cart->addItem(new Item('A', 50));

        $this->assertEquals(150, $this->cart->subTotal());
        $this->assertEquals(130, $this->rule->calculateTotal($this->cart));
    }

    public function testRuleFail()
    {
        $this->cart->addItem(new Item('A', 50));
        $this->cart->addItem(new Item('A', 50));
        $this->cart->addItem(new Item('A', 50));

        $this->assertEquals(150, $this->cart->subTotal());
        $this->assertNotEquals(150, $this->rule->calculateTotal($this->cart));
    }
}
