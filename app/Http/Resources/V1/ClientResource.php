<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ClientResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "name" => $this->name,
            "email" => $this->email,
            "phone" => $this->phone,
            "dob" => $this->dob,
            "address" => $this->address,
            "complement" => $this->complement,
            "neighbor" => $this->neighbor,
            "postal_code" => $this->postal_code,
            "sign_date" => date("d/m/Y H:i:s", strtotime($this->sign_date)),
        ];
    }
}
