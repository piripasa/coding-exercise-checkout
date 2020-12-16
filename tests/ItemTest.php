<?php


namespace Tests;


use App\Entities\Item;
use PHPUnit\Framework\TestCase;

class ItemTest extends TestCase
{
    public function testSkuShouldNotNull()
    {
        $this->expectException(\TypeError::class);
        new Item(null, 50);
    }

    public function testUnitPriceShouldNotNull()
    {
        $this->expectException(\TypeError::class);
        new Item('A', null);
    }

    public function testUnitPriceShouldBeInteger()
    {
        $this->expectException(\TypeError::class);
        new Item('A', 'fifty');
    }

    public function testGetSuccess()
    {
        $item = new Item('A', 50);
        $this->assertEquals('A', $item->getSku());
        $this->assertEquals(50, $item->getUnitPrice());
    }
}
