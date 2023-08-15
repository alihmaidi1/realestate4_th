<?php

namespace App\Http\Resources\User\post;

use App\Http\Resources\User\Comment\CommentsResource;
use App\Http\Resources\User\Images\IndexImagesResource;
use App\Http\Resources\User\Information\PostInformationResource;
use App\Http\Resources\User\Type\PostTypesResource;
use Illuminate\Http\Resources\Json\JsonResource;

class indexpostResource extends JsonResource
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
      "description" => $this->description,
      "longitude" => $this->longitude,
      "latitude" => $this->latitude,
      "available" => $this->available,
      "diffInDay" => $this->diffInDay,
      "image_main" => $this->image_main,
      "user_id" => $this->user_id,
      "user_name" => $this->his_user->name,
      "area" => $this->area->name,
      "city" => $this->area->city->name,
      "category_name" => $this->category->name,
      "is_favorite" => $this->is_favorite,
      "comments" => CommentsResource::collection($this->comments),
      "images" => IndexImagesResource::collection($this->images),
      "informations" => PostInformationResource::collection($this->informations),
      "types" => PostTypesResource::collection($this->types),
    ];
  }
}
