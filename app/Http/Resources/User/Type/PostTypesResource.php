<?php

namespace App\Http\Resources\User\Type;

use Illuminate\Http\Resources\Json\JsonResource;

class PostTypesResource extends JsonResource
{
  /**
   * Transform the resource into an array.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
   */
  public function toArray($request)
  {
    return [
      "id" => $this->id,
      "name" => $this->name,
      "price" => $this->pivot->price,
      "start_date" => $this->pivot->start_date,
      "end_date" => $this->pivot->end_date,
    ];
  }
}
