<?php

namespace App\Http\Resources\User\Comment;

use Illuminate\Http\Resources\Json\JsonResource;

class CommentsResource extends JsonResource
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
      'content' => $this->content,
      'user_name' => $this->user->name,
      'user_image' => $this->user->image_path,
      'replys' => CommentsResource::collection($this->whenLoaded('replys')),
    ];
  }
}
