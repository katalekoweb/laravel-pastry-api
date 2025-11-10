<?php

namespace App\Repositories\V1;

use App\Models\Product;
use Illuminate\Support\Collection;

interface ProductRepositoryInterface
{
    public function list (): Collection;
    public function create (array $data): Product;
    public function read (int $id): Product|null;
    public function update (array $data, int $id): Product;
    public function delete (int $id): void;
    public function restore (int|null $id): bool;
}
