<?php

namespace App\Repository\Classes;

use App\Models\Role;
use App\Repository\Interfaces\RoleRepoInterface;

class RoleRepo implements RoleRepoInterface
{
  public function get($id, $with_users_relation = false)
  {
    return ($with_users_relation) ? Role::with('users')->find($id) :  Role::find($id);
  }

  public function getAllroles($with_admins_relation = false)
  {
    return ($with_admins_relation) ? Role::with('users')->get() :  Role::get();
  }

  public function create($request)
  {
    $role =  Role::create([
      "name" => $request->name
    ]);
    $role->permissions()->attach(explode(',', $request->permissions));
    return $role;
  }

  public function update($id, $request)
  {
    $updated_role = $this->get($id);
    $updated_role->update(['name' => $request["name"]]);
    $updated_role->permissions()->attach(explode(',', $request["permissions"]));
    return $updated_role;
  }

  public function delete($id)
  {
    $del = $this->get($id);
    return ($del) ? $del->delete() : false;
  }
}
