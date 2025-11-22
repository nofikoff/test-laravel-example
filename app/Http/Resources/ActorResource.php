<?php

namespace App\Http\Resources;

use App\Models\Actor;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Actor
 */
class ActorResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'email' => $this->email,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'address' => $this->address,
            'description' => $this->description,
            'height' => $this->height,
            'weight' => $this->weight,
            'gender' => $this->gender,
            'age' => $this->age,
            'created_at' => $this->created_at,
        ];
    }
}
