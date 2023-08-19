<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
  use HasFactory;
  protected $fillable = ['from_user', 'to_user', 'content'];

  public function fromUser()
  {
    return $this->belongsTo(User::class, 'from_user');
  }

  public function toUser()
  {
    return $this->belongsTo(User::class, 'to_user');
  }

  protected $casts = [
    'created_at' => 'date:m/d/Y',
  ];

  protected $appends = ['diffInMinutes'];

  public function getDiffInMinutesAttribute()
  {
    return now()->diffInMinutes($this->created_at);
  }
}
