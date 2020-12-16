<?php


namespace App\Rules;


use App\Interfaces\CheckoutInterface;

abstract class AbstractCheckoutRules
{
    public abstract function calculateTotal(CheckoutInterface $cart);
}
