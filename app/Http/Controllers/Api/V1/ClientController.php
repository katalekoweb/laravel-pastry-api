<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\ClientRequest;
use App\Http\Resources\V1\ClientResource;
use App\Repositories\V1\ClientRepositoryInterface;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function __construct(private ClientRepositoryInterface $clientRepository) {}

    public function index()
    {
        return ClientResource::collection($this->clientRepository->list());
    }

    public function store(ClientRequest $request)
    {
        return new ClientResource($this->clientRepository->create($request->validated()));
    }

    public function show(int $id)
    {
        return new ClientResource($this->clientRepository->read($id));
    }

    public function update(ClientRequest $request, string $id)
    {
        return new ClientResource($this->clientRepository->update($request->validated(), $id));
    }

    public function destroy(string $id)
    {
        $this->clientRepository->delete($id);
        return response()->noContent();
    }
}
