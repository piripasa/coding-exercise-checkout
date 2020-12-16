<?php


namespace App\Rules;


use App\Interfaces\CartInterface;

class BundlePriceRule extends AbstractPriceRules
{
    private $rules;

    /**
     * BundlePriceRule constructor.
     * @param array $rules
     */
    public function __construct(array $rules)
    {
        $this->rules = $rules;
    }

    /**
     * Calculate total based on rules
     * @param CartInterface $cart
     * @return float|int
     */
    public function calculateTotal(CartInterface $cart)
    {
        $countCart = [];
        $totalPrice = 0;

        foreach ($cart->getItems() as $item) {
            if (!isset($countCart[$item->getSku()])) {
                $countCart[$item->getSku()] = 0;
            }

            $countCart[$item->getSku()]++;
            $totalPrice += $item->getUnitPrice();
            if (isset($this->rules[$item->getSku()]) && $countCart[$item->getSku()] == $this->rules[$item->getSku()]['count']) {
                $totalPrice -= $this->rules[$item->getSku()]['count'] * $item->getUnitPrice();
                $totalPrice += $this->rules[$item->getSku()]['price'];
                $countCart[$item->getSku()] = 0;
            }
        }
        return $totalPrice;
    }
}
