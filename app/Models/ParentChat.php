<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParentChat extends Model
{
  use HasFactory;
  protected $table = 'parent_chats';

  protected $fillable = ['from_user', 'to_user'];

  public function fromUser()
  {
    return $this->belongsTo(User::class, 'from_user');
  }

  public function toUser()
  {
    return $this->belongsTo(User::class, 'to_user');
  }
}
