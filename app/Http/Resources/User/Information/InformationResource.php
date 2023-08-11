<?php

namespace App\Http\Resources\User\Information;

use Illuminate\Http\Resources\Json\JsonResource;

class InformationResource extends JsonResource
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
      "category_id" => $this->category_id,
      // "row_num" => $this->row_num,
      // "type_row" => $this->type_row,
      "code" => $this->code,
      // "type" => $this->type,
    ];
  }
}
