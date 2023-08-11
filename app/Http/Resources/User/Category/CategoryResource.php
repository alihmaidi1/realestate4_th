<?php

namespace App\Http\Resources\User\Category;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\User\Information\InformationResource;

class CategoryResource extends JsonResource
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
      "image_url" => $this->image_url,
      "description" => $this->description,
      "informations" => InformationResource::collection($this->whenLoaded("informations")),
    ];
  }
}
