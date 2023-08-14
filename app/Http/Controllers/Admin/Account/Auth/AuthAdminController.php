<?php

namespace App\Http\Controllers\Admin\Account\Auth;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Services\ApiResponseService;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Api\Admin\Account\Auth\LoginRequest;
use App\Http\Requests\Api\Admin\Account\Auth\RegisterRequest;

class AuthAdminController extends Controller
{
  public function register(RegisterRequest $request)
  {
    // $validator = Validator::make($request->all(), [
    //   'name' => 'required',
    //   'email' => 'required|email',
    //   'password' => 'required',
    //   'c_password' => 'required|same:password',
    // ]);

    // if ($validator->fails()) {
    //   return ApiResponseService::errorMsgResponse($validator->errors());
    // }

    $input = $request->validated();
    $input['password'] = Hash::make($input['password']);
    $user = User::create($input);
    $success['token'] =  $user->createToken('MyApp')->plainTextToken;
    $success['name'] =  $user->name;

    return ApiResponseService::successResponse(['user' => $success]);
  }

  public function login(LoginRequest $request)
  {
    $user = User::where('email', $request->email)->first();
    if (!$user || !Hash::check($request->password, $user->password)) {
      return ApiResponseService::errorMsgResponse(['password not correct'], 401);
    } else {
      $user_login_token = $user->createToken('MyApp')->plainTextToken;
      return ApiResponseService::successResponse(['token' => $user_login_token]);
    }
  }

  public function logout()
  {
    //TODO: implement test for this with gurd: api_user and without
    $user = auth('api_user')->user();
    $user->tokens()->delete();
    return ApiResponseService::successResponse(['user' => $user]);
  }
}
