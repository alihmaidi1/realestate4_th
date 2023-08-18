<?php

namespace App\Http\Resources\Chat;

use Illuminate\Http\Resources\Json\JsonResource;

class UsersResource extends JsonResource
{
  /**
   * Transform the resource into an array.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
   */
  public function toArray($request)
  {
    $auth_user = aauth();
    $user = $auth_user->id == $this->from_user ? $this->toUser : $this->fromUser;
    return [
      "user_id" => $user->id,
      "user_name" => $user->name,
      "user_image" => $user->image_path,
    ];
  }
}
