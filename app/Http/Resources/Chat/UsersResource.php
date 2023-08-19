<?php

namespace App\Http\Resources\Chat;

use App\Models\Chat;
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

    $message = Chat::where(function ($query) {
      $query->where('from_user', $this->from_user)->where('to_user', $this->to_user);
    })->orWhere(function ($query) {
      $query->where('from_user', $this->to_user)->where('to_user', $this->from_user);
    })->orderBy('created_at', 'desc')->first();

    $name = explode("&&", $user->name);
    $name = implode(' ', $name);

    return [
      "user_id" => $user->id,
      "user_name" => $name,
      "user_image" => $user->image_path,
      "last_message" => $message,
    ];
  }
}
