<?php

namespace App\Services;

use App\Models\Carts;
use App\Interfaces\CartRepositoryInterface;

class CartService
{
    protected $cartRepository;

    public function __construct(CartRepositoryInterface $cartRepository)
    {
        $this->cartRepository = $cartRepository;
    }

    public function getAllCarts(array $relations = [])
    {
        return $this->cartRepository->all($relations);
    }

    public function getCartById(int $id, array $relations = [])
    {
        return $this->cartRepository->find($id, $relations);
    }

    public function getCartByPersonId(int $id, array $relations = [])
    {
        return $this->cartRepository->findByPerson($id, $relations);
    }

    public function createCart(array $data)
    {
        return $this->cartRepository->create($data);
    }

    public function updateCart(int $id, array $data)
    {
        return $this->cartRepository->update($id, $data);
    }

    public function deleteCart(int $id)
    {
        return $this->cartRepository->delete($id);
    }

    public function addToCart(array $params)
    {
        //Check if a cart already exists for the user
        //If so just add the product to the cart
        $cart = $this->getCartByPersonId($params['person_id']);
        if($cart)
        {
            $params['cart_id'] = $cart->cart_id;
            return $this->addProductToCart($params);
        }
        //Otherwise create a cart
        $cart = $this->createCart(['person_id' => $params['person_id']]);
        // Prepare filtered data for cart items
        $filteredData = [
            'cart_id' => $cart->cart_id,
            'product_id' => $params['product_id'],
            'quantity' => $params['quantity'],
        ];
        return $this->cartRepository->addProduct($filteredData);

    }

    private function addProductToCart(array $params)
    {
        return $this->cartRepository->addProduct($params);
    }
}
