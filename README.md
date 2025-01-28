# E-Commerce Mini-Project

This repository contains a simplified e-commerce application built with Laravel 11. It demonstrates multiple concepts, including:

- **Service Layer** and **Repository Pattern**
- **Custom validation rules** using FormRequest to validate data
- **Standardized return values** using JsonResource to return only useful fields
- **User Management** (Customers, Suppliers)
- **Products** (CRUD operations)
- **Carts** and **Cart Items** (creating and adding products to a cart)
- **Database Migrations** for all tables (e.g., `users`, `person`, `person_supplier`, `products`, `carts`, etc.)
- **API Routes** using `api.php`

---

## Disclosure
During the implementation of this project, certain parts of the test were omitted due to time constraints and external factors. Specifically, the frontend implementation, Login logic and the Orders CRUD were omitted. Instead, the focus was on:

- Comprehensive database modeling.
- Implementing a complete backend CRUD for products.

The provided backend implementation showcases the thought process and design patterns used to create a scalable system. As needed, future improvements and omitted sections can be discussed in detail.

---

## Table of Contents
- [Prerequisites](#prerequisites)
- [Installation](#installation)
- [Database Setup](#database-setup)
- [Running the Application](#running-the-application)
- [Key Endpoints](#key-endpoints)
- [Project Structure](#project-structure)
- [How the Cart Works](#how-the-cart-works)
- [Notes and Future Improvements](#notes-and-future-improvements)

---

## Prerequisites
- **Docker**

---

## Installation using docker compose

1. **Clone the repository**

2. **Build & start containers**:
   ```bash
   docker compose up -d --build
   ```
3. **Copy `.env.example` to `.env`** inside the container:
   ```bash
   cp .env.example .env
   ```

4. **Install composer** inside the container:
   ```bash
    composer install
   ```
5. **Generate app key** inside the container:
   ```bash
    php artisan key:generate
   ```
6. **Run the migrations** inside the container:
   ```bash
    php artisan migrate
   ```

7. **Seed the data for countries and categories** inside the container:
   ```bash
    php artisan db:seed
   ```

The application should now be running on the port you configured in `docker-compose.yml` (commonly `http://localhost:8080`).

---

## Key Endpoints
**API Routes** are defined in `routes/api.php`. Example endpoints:

- **Products**
    - `POST /api/products` — Create a new product
    - `GET /api/products` — Retrieve all products
    - `GET /api/products/{id}` — Retrieve a single product
    - `PUT /api/products/{id}` — Update a product
    - `DELETE /api/products/{id}` — Delete a product

- **Carts**
    - `POST /api/cart` — Create a new cart
    - `GET /api/cart` — Retrieve all carts
    - `GET /api/cart/{id}` — Retrieve a single cart
    - `PUT /api/cart/{id}` — Update a cart
    - `DELETE /api/cart/{id}` — Delete a cart

---

## Project Structure
```
app/
  Http/
    Controllers/
      - ProductController.php
      - CartController.php
    Requests/
      - AddToCartRequest.php
      - ProductRequest.php
  Models/
    - Product.php
    - Cart.php
    - CartItem.php
    - Person.php
    - PersonSupplier.php
    ...
  Repositories/
    - ProductRepository.php
    - CartRepository.php
    ...
  Services/
    - ProductService.php
    - CartService.php
...
routes/
  - api.php
...
database/
  migrations/
  seeders/
```

- **Controllers** handle incoming HTTP requests and map them to service methods.
- **Services** contain business logic (e.g., creating a cart, adding a product to a cart).
- **Repositories** manage database interactions, encapsulating Eloquent queries.
- **Models** represent the tables (`Product`, `Cart`, `CartItem`, etc.).
- **Requests** handle validation of incoming data.

---

## How the Product Logic Works
1. **Create Product**:
    - `ProductController.store()` receives the payload and validate it using a custom FormRequest then calls `ProductService.createProduct($data)`.
    - `ProductService` validates the input and passes it to `ProductRepository.create($data)`.
    - The `ProductRepository` saves the product to the `products` table and returns the created product to be parsed using a Resource.
2. **Retrieve Products**:
    - `ProductController.index()` calls `ProductService.getAllProducts()`.
    - The `ProductService` uses `ProductRepository.all()` to retrieve all products with their relationships (e.g., category, supplier).
    - The `ProductResource` formats the output for the API response.
3. **Retrieve Single Product**:
    - `ProductController.show($id)` calls `ProductService.getProductById($id)`.
    - The `ProductService` fetches the product using `ProductRepository.findById($id, $relations)`.
    - The `ProductResource` formats the response, including nested relationships.
4. **Update Product**:
    - `ProductController.update($id, $request)` calls `ProductService.updateProduct($id, $data)`.
    - The `ProductService` validates the input and updates the product via `ProductRepository.update($id, $data)`.
5. **Delete Product**:
    - `ProductController.destroy($id)` calls `ProductService.deleteProduct($id)`.
    - The `ProductService` uses `ProductRepository.delete($id)` to remove the product from the database.
6. **Validation**:
    - The `ProductRequest` ensures fields like `name`, `sku`, `price`, and `category_id` are valid for both creation and updates.

---

## Example API Requests

### Create Product
**Request:**
```bash
POST /api/products
```
**Payload:**
```json
{
  "name": "New Product Example",
  "description": "This is another sample product for testing.",
  "cover_img_url": "https://example.com/new-product-example.jpg",
  "sku": "SP-987654",
  "price": 29.99,
  "stock_quantity": 50,
  "is_active": true,
  "category_id": 2,
  "personsupplier_id": 2
}
```

**Response:**
```json
{
  "data": {
    "product_id": 1,
    "name": "New Product Example",
    "description": "This is another sample product for testing.",
    "coverImageUrl": "https://example.com/new-product-example.jpg",
    "sku": "SP-987654",
    "price": "29.99",
    "stockQuantity": 50,
    "isActive": 1,
    "categoryId": 2,
    "productSupplier": [
      {
        "personSupplier": {
          "person_id": 2,
          "company_name": "Global Traders Ltd.",
          "vat_number": "Nlq5YR33HJ",
          "products_count": 50
        }
      }
    ]
  }
}
```

### Get Product by ID
**Request:**
```bash
GET /api/products/1
```

**Response:**
```json
{
  "data": {
    "product_id": 1,
    "name": "New Product Example",
    "description": "This is another sample product for testing.",
    "coverImageUrl": "https://example.com/new-product-example.jpg",
    "sku": "SP-987654",
    "price": "29.99",
    "stockQuantity": 50,
    "isActive": 1,
    "categoryId": 2,
    "productSupplier": [
      {
        "personSupplier": {
          "person_id": 2,
          "company_name": "Global Traders Ltd.",
          "vat_number": "Nlq5YR33HJ",
          "products_count": 50
        }
      }
    ]
  }
}
```

---

## Notes and Future Improvements
- **Order Flow**: Next steps might include creating an `orders` table to finalize a purchase.
- **Authorization/Authentication**: Implement user authentication to ensure only the correct user can modify their cart.
- **Multiple Products**: For bulk insertion of items, pass an array of `product_id` and `quantity` pairs.
- **Testing**: Consider adding Feature/Unit tests for each endpoint.
- **Frontend**: Implement react for the frontend.

---

