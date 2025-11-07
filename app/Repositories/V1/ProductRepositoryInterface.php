<?php

namespace App\Repositories\V1;

use App\Models\Product;
use Illuminate\Support\Collection;

interface ProductRepositoryInterface
{
    public function list (): Collection;
    public function create (array $data): Product;
    public function read (int $id): Product|null;
    public function update (array $data, Product $product): Product;
    public function delete (Product $product): void;
}
