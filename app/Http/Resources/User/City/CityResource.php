<?php

namespace App\Http\Resources\User\City;

use App\Http\Resources\User\Area\AreaResource;
use Illuminate\Http\Resources\Json\JsonResource;

class CityResource extends JsonResource
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
      'name' => $this->name,
      'areas' => AreaResource::collection($this->whenLoaded('areas')),
    ];
  }
}
