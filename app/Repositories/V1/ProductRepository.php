<?php

namespace App\Repositories\V1;

use App\Models\Product;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;

class ProductRepository implements ProductRepositoryInterface
{
    public function __construct(private Product $model) {}

    public function list(): Collection
    {
        return $this->model->get();
    }

    public function create(array $data): Product
    {
        if (isset($data['photo'])) $data['photo'] = Storage::disk("public")->putFile('products', $data['photo']);
        return $this->model->create($data);
    }

    public function read(int $id): Product|null
    {
        $product = Product::find($id);
        return $product;
    }

    public function update(array $data, int $id): Product
    {
        $product = Product::find($id);
        $product?->update($data);
        return $product;
    }

    public function delete(int $id): void
    {
        $product = Product::find($id);
        $product?->delete();
    }

    public function restore(int|null $id): bool
    {
        if ($id) {
            $product = Product::onlyTrashed()->find($id);
            if ($product) {
                $product->restore();
                return true;
            }

            return false;
        }

        Product::onlyTrashed()->restore();
        return true;
    }
}
