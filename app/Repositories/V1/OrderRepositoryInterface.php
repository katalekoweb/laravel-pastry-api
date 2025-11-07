<?php

namespace App\Repositories\V1;

use App\Models\Order;
use Illuminate\Support\Collection;

interface OrderRepositoryInterface
{
    public function list (): Collection;
    public function create (array $data): Order;
    public function read (int $id): Order|null;
    public function update (array $data, int $id): Order;
    public function delete (int $id): void;
}
