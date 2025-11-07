<?php

namespace App\Repositories\V1;

use App\Models\Client;
use Illuminate\Support\Collection;

interface ClientRepositoryInterface
{
    public function list(): Collection;
    public function create(array $data): Client;
    public function read(int $id): Client|null;
    public function update(array $data, int $id): Client;
    public function delete(int $id): void;
}
