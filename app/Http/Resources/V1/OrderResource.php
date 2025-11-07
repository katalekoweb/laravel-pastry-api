<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "total" => number_format((float) $this->products?->sum('price'), 2, ".", " "),
            "client" => $this->client,
            "products" => ProductResource::collection($this->products) 
        ];
    }
}
