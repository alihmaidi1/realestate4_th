<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InformationPost extends Model
{
  use HasFactory;
  protected $fillable = ['information_id', 'post_id', 'value'];
  protected $hidden = ['crated_at', 'updated_at','information_id', 'post_id'];
}
