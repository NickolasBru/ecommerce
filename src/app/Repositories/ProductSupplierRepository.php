<?php

namespace App\Repositories;

use Illuminate\Support\Arr;
use App\Models\PersonSupplier;
use App\Models\ProductSupplier;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Interfaces\ProductSupplierRepositoryInterface;

class ProductSupplierRepository implements ProductSupplierRepositoryInterface
{
    protected $model;

    public function __construct(ProductSupplier $model)
    {
        $this->model = $model;
    }

    public function all(array $relations = [])
    {
        return $this->model->with($relations)->get();
    }

    public function find(int $id)
    {
        return $this->model->findOrFail($id);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
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
    public function deleteByProductId(int $product_id)
    {
        return $this->model->where('product_id', $product_id)->delete();
    }
    public function createRelation(int $personsupplier_id, array $product_ids)
    {
        // Prepare the data to insert into the pivot table
        $pivotData = array_map(function ($product_id) use ($personsupplier_id) {
            return [
                'personsupplier_id' => $personsupplier_id,
                'product_id' => $product_id,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }, $product_ids);
        // Insert the data into the pivot table
        DB::table('product_supplier')->insert($pivotData);

        return true;
    }
}
