<?php

namespace App\Repositories\V1;

use App\Models\Order;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;

interface OrderRepositoryInterface
{
    public function list (array $request): Collection;
    public function create (array $data): Order|JsonResponse;
    public function read (int $id): Order|null;
    public function update (array $data, int $id): Order;
    public function delete (int $id): void;
    public function restore (int|null $id): bool;
}
