<?php


namespace App\Rules;


use App\Interfaces\CartInterface;

abstract class AbstractPriceRules
{
    public abstract function calculateTotal(CartInterface $cart);
}
