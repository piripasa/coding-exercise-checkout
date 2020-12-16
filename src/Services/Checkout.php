<?php


namespace App\Services;


use App\Entities\Item;
use App\Interfaces\CartInterface;
use App\Interfaces\CheckoutInterface;
use App\Interfaces\RepositoryInterface;
use App\Rules\AbstractCheckoutRules;
use App\Rules\AbstractPriceRules;

class Checkout implements CheckoutInterface
{
    private $rulesRepository;
    private $cart;
    private $total;

    /**
     * Checkout constructor.
     * Use dependency injection, so that different rules can be used
     * @param RepositoryInterface $repository
     */
    public function __construct(RepositoryInterface $repository)
    {
        $this->rulesRepository = $repository;
        $this->cart = new Cart();
        $this->total = 0;
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
        $this->total = $this->cart->subTotal();

        foreach ($this->rulesRepository->getAll() as $priceRule) {
            if ($priceRule instanceof AbstractPriceRules) {
                $this->total = $priceRule->calculateTotal($this->cart);
            }
            if ($priceRule instanceof AbstractCheckoutRules) {
                $this->total = $priceRule->calculateTotal($this);
            }
        }

        return $this->total;
    }

    /**
     * Get cart instance
     * @return CartInterface
     */
    public function getCart(): CartInterface
    {
        return $this->cart;
    }

    public function getSubTotal()
    {
        return $this->total;
    }
}
