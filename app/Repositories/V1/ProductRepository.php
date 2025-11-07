<?php

namespace App\Repositories\V1;

use App\Models\Product;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;

class ProductRepository implements ProductRepositoryInterface
{
    /**
     * Create a new class instance.
     */
    public function __construct(private Product $model)
    {
        //
    }

    public function list(): Collection
    {
        # Product::factory(20)->create();
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

    public function update(array $data, Product $product): Product
    {
        $product->update($data);
        return $product;
    }

    public function delete(Product $product): void
    {
        $product->delete();
    }
}
