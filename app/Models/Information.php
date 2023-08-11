<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Information extends Model
{
  use HasFactory;

  protected $fillable = ['name', 'code', 'category_id'];
  public $hidden = ["created_at", "updated_at"];

  public function Category()
  {
    return $this->belongsTo(Category::class, 'category_id');
  }
}
