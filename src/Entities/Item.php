<?php


namespace App\Entities;


class Item
{
    private $sku;
    private $unitPrice;

    public function __construct(string $sku, int $unitPrice)
    {
        $this->sku = $sku;
        $this->unitPrice = $unitPrice;
    }

    /**
     * @return string
     */
    public function getSku(): string
    {
        return $this->sku;
    }

    /**
     * @return int
     */
    public function getUnitPrice(): int
    {
        return $this->unitPrice;
    }
}
