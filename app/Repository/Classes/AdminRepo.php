<?php

namespace App\Repository\Classes;


use App\Models\User;
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
    $user = User::create($request);
    return $user->load('role');
  }
  // Update
  public function update($request)
  {
    $user =  $this->get($request["id"]);

    $user->update([
      "name" => $request["name"],
      "email" => $request["email"],
      "role_id" => $request["role_id"],
      "phone" => $request["phone"],
      "image_path" => uploadImage($request["image"], 'users/' . $user->id, 'attachments'),
      "gender" => $request["gender"],
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
