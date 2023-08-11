<?php

namespace App\Models\Location;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
  use HasFactory;

  protected $fillable = ["name", "city_id"];
  protected $hidden = ["created_at", "updated_at"];

  public function city()
  {
    return $this->belongsTo(City::class);
  }
}
