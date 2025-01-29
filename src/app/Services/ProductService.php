<?php

namespace App\Services;

use App\Models\Products;
use App\Models\ProductSupplier;
use App\Interfaces\ProductRepositoryInterface;
use App\Interfaces\ProductSupplierRepositoryInterface;

class ProductService
{
    protected $productRepository;
    protected $productSupplierRepository;

    public function __construct(ProductRepositoryInterface $productRepository, ProductSupplierRepositoryInterface $productSupplierRepository)
    {
        $this->productRepository = $productRepository;
        $this->productSupplierRepository = $productSupplierRepository;
    }

    public function getAllProducts(array $relations = [], ?int $supplierId = null)
    {
        $query = Products::with($relations);

        // ✅ Filter by supplier ID if provided
        if ($supplierId) {
            $query->whereHas('ProductSupplier', function ($q) use ($supplierId) {
                $q->where('personsupplier_id', $supplierId);
            });
        }

        return $query->get();
    }

    public function getProductById(int $id, array $relations = [])
    {
        return $this->productRepository->find($id, $relations);
    }

    public function createProduct(array $data)
    {
        return $this->productRepository->create($data);
    }

    public function updateProduct(int $id, array $data)
    {
        return $this->productRepository->update($id, $data);
    }

    public function deleteProduct(int $id)
    {
        return $this->productRepository->delete($id);
    }

    public function createSupplierRelation($personsupplier_id, $product_id)
    {
        return $this->productSupplierRepository->createRelation($personsupplier_id, $product_id);
    }

    public function deleteSupplierRelation(int $id)
    {
        return $this->productSupplierRepository->deleteByProductId($id);
    }
}
