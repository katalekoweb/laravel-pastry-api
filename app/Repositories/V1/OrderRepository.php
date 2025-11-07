<?php

namespace App\Repositories\V1;

use App\Events\OrderCreated;
use App\Models\Order;
use App\Notifications\NewOrderNotification;
use Illuminate\Support\Collection;

class OrderRepository implements OrderRepositoryInterface
{
    /**
     * Create a new class instance.
     */
    public function __construct(private Order $model) {}

    public function list(): Collection
    {
        return $this->model->orderByDesc("id")->get();
    }

    public function create(array $data): Order
    {
        $products = $data["products"];
        unset($data['products']);

        $order = $this->model->create($data);
        $order->products()?->sync($products);

        if ($order->client->email) event(new OrderCreated($order));

        return $order;
    }

    public function read(int $id): Order|null
    {
        return Order::find($id);
    }

    public function update(array $data, int $id): Order
    {
        $products = $data["products"];
        unset($data['products']);

        $order = Order::find($id);
        $order?->update($data);

        $order->products()?->sync($products);

        return $order;
    }

    public function delete(int $id): void
    {
        $order = Order::find($id);
        $order?->delete();
    }
}
