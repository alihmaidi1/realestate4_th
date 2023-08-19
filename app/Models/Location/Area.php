<?php

namespace App\Models\Location;

use App\Models\Post;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Area extends Model
{
  use HasFactory;

  protected $fillable = ["name", "city_id"];
  protected $hidden = ["created_at", "updated_at"];

  public function city()
  {
    return $this->belongsTo(City::class);
  }

  public function posts()
  {
    return $this->hasMany(Post::class, "area_id");
  }
}
