<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\FilterRequest;
use App\Http\Requests\V1\ProductRequest;
use App\Http\Resources\V1\ProductResource;
use App\Models\Product;
use App\Repositories\V1\ProductRepositoryInterface;
use Illuminate\Http\JsonResponse;

class ProductController extends Controller
{
    public function __construct(private ProductRepositoryInterface $productRepository) {}

    /**
     * List all products with filters
     *
     *
     * @group Products
     * @authenticated
     * @bodyParam query string
     * @bodyParam sort_by string
     * @bodyParam sort_order string. Example: desc
     * @response 200 {
     *   "data": [
     *     {
     *       "id": 1,
     *       "name": "Item 1",
     *       "price": 123.00,
     *       "status": true,
     *       "photo": "path/image.png"
     *     }
     *   ]
     * }
     */
    public function index(FilterRequest $request)
    {
        $products = $this->productRepository->list($request->validated());
        return ProductResource::collection($products);
    }

    /**
     * @group Products
     * @authenticated
     * @bodyParam name string required. Example: Item1 1
     * @bodyParam price string required. Example: 123.99
     * @bodyParam status number required. Example: 1
     * @bodyParam photo file required 
     * @response 201 {
     *   "id": 1,
     *   "name": "Item1 1",
     *   "price": 123.99,
     *   "status": 1
     *   "photo": "path/image.png"
     * }
     */
    public function store(ProductRequest $request)
    {
        $product = $this->productRepository->create($request->validated());
        return response()->json(new ProductResource($product), 201);
    }

    /**
     * Retrieve a product by ID
     * 
     * @group Products
     * @authenticated
     * @urlParam id int required The ID of the product. Example: 1
     * 
     * @response 201 {
     *   "id": 1,
     *   "name": "Item1 1",
     *   "price": 123.99,
     *   "status": 1
     *   "photo": "path/image.png"
     * }
     */
    public function show(int $id)
    {
        $product = $this->productRepository->read($id);
        return $product ? new ProductResource($product) : $product;
    }

    /**
     * Update a product
     * 
     * @group Products
     * @authenticated
     * @urlParam id int required The ID of the product. Example: 1
     * 
     * @bodyParam name string required. Example: Item1 1
     * @bodyParam price string required. Example: 123.99
     * @bodyParam status number required. Example: 1
     * @bodyParam photo file required 
     * @response 201 {
     *   "id": 1,
     *   "name": "Item1 1",
     *   "price": 123.99,
     *   "status": 1
     *   "photo": "path/image.png"
     * }
     */
    public function update(ProductRequest $request, int $id)
    {
        $product = $this->productRepository->update($request->validated(), $id);
        return new ProductResource($product);
    }

    /**
     * Delete a product by ID
     *
     * @group Products
     * @authenticated
     * @urlParam id int required The ID of the product. Example: 1
     *
     * @response 200 {}
     * @response 404 {
     *   "error": "Product not found"
     * }
     */
    public function destroy(int $id)
    {
        $this->productRepository->delete($id);
        return response()->noContent();
    }

    /**
     * Restore a product by ID
     *
     * @group Products
     * @authenticated
     * @urlParam id int required The ID of the product. Example: 1
     *
     * @response 200 {}
     * @response 404 {
     *   "message": "Product not found"
     * }
     */
    public function restore(int|null $id = null): JsonResponse
    {
        $restore = $this->productRepository->restore($id);

        if ($restore) {
            return response()->json([
                "message" => "Produto(s) restaurado(s) com sucesso"
            ], 200);
        }

        return response()->json([
            "message" => "Ocorreu um erro. O produto não foi encontrado"
        ], 404);
    }
}
