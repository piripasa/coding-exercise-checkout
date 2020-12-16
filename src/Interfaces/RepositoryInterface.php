<?php


namespace App\Interfaces;


interface RepositoryInterface
{
    public function add($item);

    public function getAll();
}
