<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Services\CartService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductResource;
use App\Http\Requests\AddToCartRequest;
use App\Http\Resources\ProductsCollection;
use Symfony\Component\HttpFoundation\Response;

class CartController extends Controller
{
    protected CartService $service;

    public function __construct(CartService $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the products.
     *
     * @param Request $request
     * @return ProductsCollection
     */
    public function index(Request $request): ProductsCollection
    {
        return new ProductsCollection($this->service->getAllProducts(['category', 'productSupplier.personSupplier.Person']));
    }

    /**
     * Display the specified product.
     *
     * @param int $id
     * @return ProductResource
     */
    public function show(int $id): ProductResource
    {
        return new ProductResource($this->service->getProductById($id, ['category', 'productSupplier.personSupplier.Person']));
    }

    /**
     * Store a newly created product in the DB.
     *
     * @param ProductRequest $request
     * @return ProductResource|JsonResponse
     */
    public function addToCart(AddToCartRequest $request): JsonResponse|ProductResource
    {
        $params = $request->safe()->all();
Log::info('passou');
        DB::beginTransaction();

        try {
            $cart       = $this->service->addToCart($params);
            Log::info('voltou');
            Log::info($cart);

        } catch (Exception $e) {
            // Rollback if an error occur
            DB::rollBack();

            $message = $e->getMessage() ?? 'Error received';

            $code = $e->getCode();
            Log::info('voltou');
            Log::info($e);
            if (!$code || $code < 100) {
                $code = Response::HTTP_INTERNAL_SERVER_ERROR;;
            }

            return response()->json(
                ['message' => $message],
                $code
            );
        }

        DB::commit();

        return true;

    }
    /**
     * Store a newly created product in the DB.
     *
     * @param ProductRequest $request
     * @return ProductResource|JsonResponse
     */
    public function store(ProductRequest $request): JsonResponse|ProductResource
    {

        $params = $request->safe()->all();

        DB::beginTransaction();

        try {
            $product       = $this->service->createProduct($params);
            //Doing a cast in this case because the ideia right now is just create a single product, but the more future proof solution would allow for a bulk insert of products.
            $this->service->createSupplierRelation($params['personsupplier_id'], array ($product->product_id));
        } catch (Exception $e) {
            // Rollback if an error occur
            DB::rollBack();

            $message = $e->getMessage() ?? 'Error received';

            $code = $e->getCode();
            if (!$code || $code < 100) {
                $code = Response::HTTP_INTERNAL_SERVER_ERROR;;
            }

            return response()->json(
                ['message' => $message],
                $code
            );
        }

        DB::commit();

        return new ProductResource($product);
    }

    /**
     * Update the specified product in storage.
     *
     * @param ProductRequest $request
     * @param int            $id
     * @return JsonResponse|ProductResource
     */
    public function update(ProductRequest $request, int $id): JsonResponse|ProductResource
    {
        $params = $request->safe()->all();

        DB::beginTransaction();

        try {
            // Update the product
            $product = $this->service->updateProduct($id, $params);

        } catch (\Exception $e) {
            // Rollback if an error occur
            DB::rollBack();

            $message = $e->getMessage() ?? 'Error received';

            $code = $e->getCode();
            if (!$code || $code < 100) {
                $code = Response::HTTP_INTERNAL_SERVER_ERROR;;
            }

            return response()->json(
                ['message' => $message],
                $code
            );
        }

        DB::commit();

        return new ProductResource($product);
    }

    /**
     * Remove the specified product from storage.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        DB::beginTransaction();

        try {
            // Find and delete the product
            $product = $this->service->getProductById($id);

            if (!$product) {
                return response()->json(
                    ['message' => 'Product not found'],
                    Response::HTTP_NOT_FOUND
                );
            }

            //This destroy is based on this specific case
            //When designing the solution I've imagined a eCommerce similar to Amazon, where there's one product and many suppliers/sellers of the same product
            //to simplify thing,s I'm deleting the product itself and the pivot table that links the supplier to it
            //in an actual live product, only the relation would be deleted
            $this->service->deleteSupplierRelation($product->product_id);
            $this->service->deleteProduct($id);
        } catch (Exception $e) {
            Log::info($e);

            // Rollback if an error occurs
            DB::rollBack();

            $message = $e->getMessage() ?? 'Error received';

            $code = $e->getCode();
            if (!$code || $code < 100) {
                $code = Response::HTTP_INTERNAL_SERVER_ERROR;
            }

            return response()->json(
                ['message' => $message],
                $code
            );
        }

        DB::commit();

        return response()->json(
            ['message' => 'Product deleted successfully.'],
            Response::HTTP_OK
        );
    }


}
