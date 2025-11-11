<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\FilterRequest;
use App\Http\Requests\V1\OrderRequest;
use App\Http\Resources\V1\OrderResource;
use App\Repositories\V1\OrderRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function __construct(private OrderRepositoryInterface $orderRepository) {}

    /**
     * @group Orders
     * @authenticated
     */
    public function index(FilterRequest $request)
    {
        return OrderResource::collection($this->orderRepository->list($request->validated()));
    }

    /**
     * @group Orders
     * @authenticated
     */
    public function store(OrderRequest $request)
    {
        return new OrderResource($this->orderRepository->create($request->validated()));
    }

    /**
     * @group Orders
     * @authenticated
     */
    public function show(int $id)
    {
        return new OrderResource($this->orderRepository->read($id));
    }

    /**
     * @group Orders
     * @authenticated
     */
    public function update(OrderRequest $request, string $id)
    {
        return new OrderResource($this->orderRepository->update($request->validated(), $id));
    }

    /**
     * @group Orders
     * @authenticated
     */
    public function destroy(string $id)
    {
        $this->orderRepository->delete($id);
        return response()->noContent();
    }

    /**
     * @group Orders
     * @authenticated
     */
    public function restore(int|null $id = null): JsonResponse
    {
        $restore = $this->orderRepository->restore($id);

        if ($restore) {
            return response()->json([
                "message" => "Pedidos(s) restaurado(s) com sucesso"
            ], 200);
        }

        return response()->json([
            "message" => "Ocorreu um erro. O pedido não foi encontrado"
        ], 404);
    }
}
