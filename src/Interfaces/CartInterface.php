<?php


namespace App\Interfaces;


use App\Entities\Item;

interface CartInterface
{
    public function getItems(): array;

    public function addItem(Item $item);

    public function subTotal();

    public function itemCount();
}
