<?php

namespace App\Interfaces;

interface ProductSupplierRepositoryInterface
{
    public function all();

    public function find(int $id);

    public function create(array $data);

    public function update(int $id, array $data);

    public function delete(int $id);

    public function deleteByProductId(int $id);

    public function createRelation(int $personsupplier_id, array $product_ids);
}
