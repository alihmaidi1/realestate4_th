<?php

namespace App\Models;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PermissionRole extends Model
{
  use HasFactory;
  public $table = 'permission_roles';

  protected $fillable = ['permission_id', 'role_id'];
  public $hidden = ["created_at", "updated_at"];

  public function permission()
  {
    $this->belongsTo(Permission::class);
  }

  public function role()
  {
    $this->belongsTo(Role::class);
  }
}
