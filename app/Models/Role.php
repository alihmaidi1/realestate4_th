<?php

namespace App\Models;

use App\Models\Admin;
use App\Models\Permission;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Role extends Model
{
  use HasFactory;

  protected $fillable = ['name'];
  public $hidden = ["created_at", "updated_at"];

  public function users()
  {
    return $this->hasMany(User::class, "role_id");
  }

  public function permissions()
  {
    return $this->belongsToMany(Permission::class, 'permission_roles');
  }
}
