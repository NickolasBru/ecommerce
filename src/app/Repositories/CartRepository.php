<?php

namespace App\Repositories;

use App\Models\Carts;
use App\Interfaces\CartRepositoryInterface;

class CartRepository implements CartRepositoryInterface
{
    protected $model;

    public function __construct(Carts $model)
    {
        $this->model = $model;
    }

    public function all(array $relations = [])
    {
        return $this->model->with($relations)->get();
    }

    public function find(int $id, array $relations = [])
    {
        return $this->model->with($relations)->findOrFail($id);
    }

    public function findByPerson(int $id, array $relations = [])
    {
        return $this->model->where('person_id', $id)->first();
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function addProduct(array $data)
    {
        \Log::info($data);
        return $this->model->cartItems()->create($data);
    }

    public function update(int $id, array $data)
    {
        $product = $this->find($id);
        $product->update($data);
        return $product;
    }

    public function delete(int $id)
    {
        $product = $this->find($id);
        return $product->delete();
    }
}
