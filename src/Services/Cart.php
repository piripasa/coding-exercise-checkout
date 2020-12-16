<?php


namespace App\Services;


use App\Entities\Item;
use App\Interfaces\CartInterface;

class Cart implements CartInterface
{
    private $items;

    /**
     * Cart constructor.
     */
    public function __construct()
    {
        $this->items = [];
    }

    /**
     * Get cart items
     * @return array
     */
    public function getItems(): array
    {
        return $this->items;
    }

    /**
     * Add a item to cart
     * @param Item $item
     */
    public function addItem(Item $item)
    {
        $this->items[] = $item;
    }

    /**
     * Get cart item total price
     * @return int
     */
    public function subTotal()
    {
        $total = 0;
        foreach ($this->items as $item) {
            $total += $item->getUnitPrice();
        }

        return $total;
    }

    /**
     * Get cart item count
     * @return int
     */
    public function itemCount()
    {
        return count($this->items);
    }
}
