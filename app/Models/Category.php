<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
  use HasFactory;

  protected $fillable = ['name', 'image_url', 'description'];
  public $hidden = ["created_at", "updated_at"];

  public function posts()
  {
    return $this->hasMany(Post::class);
  }

  public function informations()
  {
    return $this->hasMany(Information::class);
  }

  public function scopeRelations($query)
  {
    return $query->with(['posts', 'informations']);
  }
}
