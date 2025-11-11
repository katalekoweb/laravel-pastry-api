<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class ProductResource extends JsonResource
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
            "name" => $this->name,
            "category_id" => $this->category_id,
            "category" => $this->category,
            "price" => number_format((float)$this->price, 2, ".", " "),
            "photo" => $this->when($this->photo, url(Storage::url($this->photo)), null)
        ];
    }
}
