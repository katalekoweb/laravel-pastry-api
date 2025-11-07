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

    /**
     * List all clients
     *
     * Get a list of clients with optional pagination.
     *
     * @group Clients
     * @authenticated
     * @response 200 {
     *   "data": [
     *     {
     *       "id": 1,
     *       "name": "John",
     *       "email": "john.doe@example.com",
     *       "phone": "+123456789",
     *       "address": "123 Main St"
     *     }
     *   ]
     * }
     */
    public function index()
    {
        return ClientResource::collection($this->clientRepository->list());
    }

    /**
     * @group Clients
     * @authenticated
     * @bodyParam name string required. Example: Joao
     * @bodyParam email string  required. Example: john@mail.com
     * @bodyParam phone string.
     * @bodyParam address string.
     * @response 201 {
     *   "id": 1,
     *   "name": John,
     *   "email": "email@mail.com",
     *   "phone": "999999999999"
     *   "address": "999999999999"
     * }
     */
    public function store(ClientRequest $request)
    {
        return new ClientResource($this->clientRepository->create($request->validated()));
    }

    /**
     * Retrieve a client by ID
     *
     * Get a list of clients with optional pagination.
     *
     * @group Clients
     * @authenticated
     * @response 200 {
     *   "data": {
     *       "id": 1,
     *       "name": "John",
     *       "email": "john.doe@example.com",
     *       "phone": "+123456789",
     *       "address": "123 Main St"
     *    }
     * }
     */
    public function show(int $id)
    {
        return new ClientResource($this->clientRepository->read($id));
    }

    /**
     * Update a client
     *
     * @group Clients
     * @authenticated
     * @urlParam id int required The ID of the client. Example: 1
     * @bodyParam name string Client's first name. Example: Jane
     * @bodyParam email string Client's email. Example: jane.doe@example.com
     * @bodyParam phone string Client's phone number. Example: +1122334455
     * @bodyParam address string Client's address. Example: 789 Oak St
     *
     * @response 200 {
     *   "id": 1,
     *   "name": "Jane",
     *   "email": "jane.doe@example.com",
     *   "phone": "+1122334455",
     *   "address": "789 Oak St",
     * }
     * @response 404 {
     *   "error": "Client not found"
     * }
     */
    public function update(ClientRequest $request, string $id)
    {
        return new ClientResource($this->clientRepository->update($request->validated(), $id));
    }

    /**
     * Delete a client by ID
     *
     * @group Clients
     * @authenticated
     * @urlParam id int required The ID of the client. Example: 1
     *
     * @response 200 {}
     * @response 404 {
     *   "error": "Client not found"
     * }
     */
    public function destroy(string $id)
    {
        $this->clientRepository->delete($id);
        return response()->noContent();
    }
}
