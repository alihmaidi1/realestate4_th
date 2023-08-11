<?php

namespace App\Models\Location;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
  use HasFactory;

  protected $fillable = ["name", "country_id"];
  protected $hidden = ["created_at", "updated_at"];

  public function areas()
  {
    return $this->hasMany(Area::class, 'city_id');
  }

  public function country()
  {
    return $this->belongsTo(Country::class, 'country_id');
  }
}
