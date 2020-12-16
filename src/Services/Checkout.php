<?php


namespace App\Services;


use App\Entities\Item;
use App\Interfaces\CartInterface;
use App\Interfaces\CheckoutInterface;
use App\Interfaces\RepositoryInterface;
use App\Rules\AbstractPriceRules;

class Checkout implements CheckoutInterface
{
    private $rulesRepository;
    private $cart;

    /**
     * Checkout constructor.
     * Use dependency injection, so that different rules can be used
     * @param RepositoryInterface $repository
     */
    public function __construct(RepositoryInterface $repository)
    {
        $this->rulesRepository = $repository;
        $this->cart = new Cart();
    }

    /**
     * Scan item to add to cart
     * @param Item $item
     */
    public function scan(Item $item)
    {
        $this->cart->addItem($item);
    }

    /**
     * Get total price after applying rules
     * @return int
     */
    public function total()
    {
        $total = 0;
        if (!empty($this->rulesRepository->getAll())) {
            foreach ($this->rulesRepository->getAll() as $priceRule) {
                if ($priceRule instanceof AbstractPriceRules) {
                    $total = $priceRule->calculateTotal($this->cart);
                }
            }
        } else {
            $total = $this->cart->subTotal();
        }

        return $total;
    }

    /**
     * Get cart instance
     * @return CartInterface
     */
    public function getCart(): CartInterface
    {
        return $this->cart;
    }
}
