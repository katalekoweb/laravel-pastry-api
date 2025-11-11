<?php

namespace App\Repositories\V1;

use App\Http\Requests\V1\FilterRequest;
use App\Models\Client;
use Illuminate\Support\Collection;

class ClientRepository implements ClientRepositoryInterface
{
    public function __construct(private Client $model) {}

    public function list(array $request): Collection
    {
        return $this->model
                ->withTrashed($request['with_trashed'])
                ->when(isset($request['query']), function ($query) use ($request) {
                    $query->where('name', 'like', '%' . $request['query'] . '%')
                            ->orWhere('email', 'like', '%' . $request['query'] . '%')
                            ->orWhere('phone', 'like', '%' . $request['query'] . '%');
                })
                ->orderBy($request['sort_by'], $request['sort_order'])
                ->get();
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
