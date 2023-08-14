<?php

namespace App\Http\Resources\User\Country;

use App\Http\Resources\User\City\CityResource;
use Illuminate\Http\Resources\Json\JsonResource;

class CountryResource extends JsonResource
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
      'cities' => CityResource::collection($this->cities),
      // 'cities' => CityResource::collection($this->whenLoaded('cities')),
    ];
  }
}
