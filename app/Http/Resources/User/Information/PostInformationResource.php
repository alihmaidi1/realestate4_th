<?php

namespace App\Http\Resources\User\Information;

use Illuminate\Http\Resources\Json\JsonResource;

class PostInformationResource extends JsonResource
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
      "value" => $this->pivot->value,
      "code" => $this->code,
      // "type" => $this->type,
      // "row_num" => $this->row_num,
      // "type_row" => $this->type_row,
    ];
  }
}
