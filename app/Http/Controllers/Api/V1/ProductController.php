<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\ProductRequest;
use App\Http\Resources\V1\ProductResource;
use App\Models\Product;
use App\Repositories\V1\ProductRepositoryInterface;
class ProductController extends Controller
{
    public function __construct(private ProductRepositoryInterface $productRepository) {}

    public function index()
    {
        $products = $this->productRepository->list();
        return ProductResource::collection($products);
    }

    public function store(ProductRequest $request)
    {
        $product = $this->productRepository->create($request->validated());
        return response()->json(new ProductResource($product), 201);
    }

    public function show(int $id)
    {
        $product = $this->productRepository->read($id);
        return $product ? new ProductResource($product) : $product;
    }

    public function update(ProductRequest $request, int $id)
    {
        $product = $this->productRepository->update($request->validated(), $id);
        return new ProductResource($product);
    }

    public function destroy(int $id)
    {
        $this->productRepository->delete($id);
        return response()->noContent();
    }
}
