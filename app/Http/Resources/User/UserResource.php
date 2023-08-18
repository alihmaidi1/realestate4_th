<?php

namespace App\Http\Resources\User;

use App\Http\Resources\User\Comment\CommentsResource;
use App\Http\Resources\User\Notification\NotificationResource;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\User\post\indexpostResource;
use App\Http\Resources\User\Permissions\PermissionssResource;

class UserResource extends JsonResource
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
      "email" => $this->email,
      "is_verified" => $this->is_verified,
      "phone" => $this->phone,
      "role_name" => $this->role->name,
      "status" => $this->status,
      "role_id" => $this->role_id,
      "image_path" => $this->image_path,
      "gender" => $this->gender,
      "permissions" => PermissionssResource::collection($this->role->permissions),
      "posts" => indexpostResource::collection($this->posts),
      // "comments" => CommentsResource::collection($this->comments),
      "notifications" => NotificationResource::collection($this->unreadNotifications),
      "notifications_count" => $this->unreadNotifications->count(),
      // "favorite_posts" => indexpostResource::collection($this->favorite_posts),
    ];
  }
}
