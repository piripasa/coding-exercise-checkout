<?php


namespace App\Repositories;


use App\Interfaces\RepositoryInterface;

class RulesRepository implements RepositoryInterface
{
    private $rules = [];

    /**
     * Add rule to repository
     * @param $item
     */
    public function add($item)
    {
        $this->rules[] = $item;
    }

    /**
     * Get rules
     * @return array
     */
    public function getAll(): array
    {
        return $this->rules;
    }
}
