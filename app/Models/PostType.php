<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostType extends Model
{
  use HasFactory;

  protected $fillable = ['post_id', 'type_id', 'price', 'start_date', 'end_date'];
  public $hidden = ["created_at", "updated_at"];
}
