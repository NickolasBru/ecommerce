<?php

namespace App\Interfaces;

interface CartRepositoryInterface
{
    public function all();

    public function find(int $id);

    public function create(array $data);

    public function update(int $id, array $data);

    public function delete(int $id);

    public function findByPerson(int $id, array $relations);

    public function addProduct(array $params);
}
