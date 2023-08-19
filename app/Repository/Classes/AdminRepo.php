<?php

namespace App\Repository\Classes;


use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Repository\Interfaces\AdminRepoInterface;

class AdminRepo implements AdminRepoInterface
{
  // Get One User
  public function get($id, $with_role = false)
  {
    return ($with_role) ? User::with('role')->find($id) :  User::find($id);
  }
  // Get All Users
  public function getAllUsers()
  {
    return User::where("id", "!=", aauth()->id)->with('role')->get();
  }
  // Create
  public function create($request)
  {
    $user = User::create([
      'name' => $request["name"],
      'email' => $request["email"],
      'password' => Hash::make($request['password']),
      'role_id' => $request["role_id"],
      'phone' => $request["phone"],
    ]);
    return $user->load('role');
  }
  // Update
  public function update($request)
  {
    $user = User::find(aauth()->id);
    $user->update([
      "name" => $request["name"],
      "phone" => $request["phone"],
      "email" => $request["email"],
      "gender" => $request["gender"],
      "role_id" => $request["role_id"],
    ]);
    return $user;
  }
  // Delete
  public function delete($id)
  {
    $del = $this->get($id);
    return ($del) ? $del->delete() : false;
  }
  // Get All ermissions
  public function getAllPermissions()
  {
  }
}
