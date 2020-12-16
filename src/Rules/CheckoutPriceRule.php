<?php


namespace App\Rules;


use App\Interfaces\CheckoutInterface;

class CheckoutPriceRule extends AbstractCheckoutRules
{
    private $threshold;
    private $discount;

    public function __construct(int $threshold, int $discount)
    {
        $this->threshold = $threshold;
        $this->discount = $discount;
    }

    public function calculateTotal(CheckoutInterface $cart)
    {
        $total = $cart->getSubTotal();
        if ($total > $this->threshold) {
            $total = $total - ($total * ($this->discount/100));
        }
        return $total;
    }
}
