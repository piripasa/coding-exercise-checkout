<?php


namespace Tests;


use App\Entities\Item;
use App\Services\Cart;
use PHPUnit\Framework\TestCase;

class CartTest extends TestCase
{
    private $cart;

    public function setUp()
    {
        parent::setUp();

        $this->cart = new Cart();
    }

    public function testCartItemShouldBeValid()
    {
        $this->expectException(\TypeError::class);
        $this->cart->addItem(null);
    }

    public function testGetCartItems()
    {
        $this->cart->addItem(new Item('A', 50));
        $this->assertIsArray($this->cart->getItems());
    }

    public function testCartItemSubTotal()
    {
        $this->cart->addItem(new Item('A', 50));
        $this->cart->addItem(new Item('B', 30));
        $this->assertEquals(80, $this->cart->subTotal());
    }

    public function testCartItemCount()
    {
        $this->cart->addItem(new Item('A', 50));
        $this->cart->addItem(new Item('B', 30));
        $this->assertEquals(2, $this->cart->itemCount());
    }
}
