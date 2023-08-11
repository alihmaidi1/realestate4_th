<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use App\Services\ApiResponseService;
use App\Repository\Interfaces\RoleRepoInterface;
use App\Http\Requests\Api\Admin\Role\CreateRoleRequest;
use App\Http\Requests\Api\Admin\Role\UpdateRoleRequest;

class RoleController extends Controller
{
  protected $RoleRepoInterface;
  public function __construct(RoleRepoInterface $RoleRepoInterface)
  {
    // $this->middleware('can:role');
    $this->RoleRepoInterface = $RoleRepoInterface;
  }

  /**
   * Show the form for creating a new resource.
   */
  public function index()
  {
    return ApiResponseService::successResponse(['roles' => $this->RoleRepoInterface->getAllroles(true)]);
  }


  /**
   * Display a listing of the resource.
   */
  public function show($id)
  {
    $role = $this->RoleRepoInterface->get($id, true);
    if ($role) {
      return ApiResponseService::successResponse(['role' => $role]);
    } else {
      return ApiResponseService::notFoundResponse();
    }
  }

  /**
   * Display the specified resource.
   */
  public function create(CreateRoleRequest $request)
  {
    return ApiResponseService::successResponse(['role' => $this->RoleRepoInterface->create($request)]);
  }

  /** This is custom comments
   * Function To Update Role
   *
   * @param UpdateRoleRequest $request
   * @return Role The role after updated
   */
  public function update(UpdateRoleRequest $request, $id)
  {
    return ApiResponseService::successResponse(['role' => $this->RoleRepoInterface->update($id, $request->validated())]);
  }

  /**
   * Remove the specified resource from storage.
   */
  public function delete($id)
  {
    $role = $this->RoleRepoInterface->delete($id);
    if ($role)
      return ApiResponseService::successMsgResponse();
    else
      return ApiResponseService::notFoundResponse();
  }
}
