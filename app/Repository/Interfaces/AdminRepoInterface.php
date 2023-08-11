<?php

namespace App\Repository\Interfaces;

interface AdminRepoInterface
{
  // Get
  public function get($id, $with_role = false);
  // Get All Admins
  public function getAllUsers();
  // Create
  public function create($request);
  // Update
  public function update($request);
  // Delete
  public function delete($id);
  // Get All ermissions
  public function getAllPermissions();
}
