<?php

namespace App\Repositories\V1;

use App\Models\Client;
use Illuminate\Support\Collection;

class ClientRepository implements ClientRepositoryInterface
{
    public function __construct(private Client $model) {}

    public function list(): Collection
    {
        return $this->model->get();
    }

    public function create(array $data): Client
    {
        return $this->model->create($data);
    }

    public function read(int $id): Client|null
    {
        return Client::find($id);
    }

    public function update(array $data, int $id): Client
    {
        $client = Client::find($id);
        $client?->update($data);
        return $client;
    }

    public function delete(int $id): void
    {
        $client = Client::find($id);
        $client?->delete();
    }

    public function restore(int|null $id): bool
    {
        if ($id) {
            $client = Client::onlyTrashed()->find($id);
            if ($client) {
                $client->restore();
                return true;
            }

            return false;
        }

        Client::onlyTrashed()->restore();
        return true;
    }
}
