<?php

namespace App\Models\Location;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
  use HasFactory;

  protected $fillable = ["name"];
  protected $hidden = ["created_at", "updated_at"];

  public function cities()
  {
    return $this->hasMany(City::class,'country_id');
  }
}
