<?php

namespace App\Repository\Interfaces;

interface RoleRepoInterface
{
  // Get
  public function get($id, $with_users_relation = false);
  // Get All Roles
  public function getAllroles($with_admins_relation = false);
  // Create
  public function create($request);
  // Update
  public function update($id, $request);
  // Delete
  public function delete($id);
}
