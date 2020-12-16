<?php


namespace App\Interfaces;


use App\Entities\Item;

interface CheckoutInterface
{
    public function scan(Item $item);

    public function total();

    public function getCart(): CartInterface;

    public function getSubTotal();
}
