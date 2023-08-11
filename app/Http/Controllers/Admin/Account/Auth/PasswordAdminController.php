<?php

namespace App\Http\Controllers\Admin\Account\Auth;

use App\Models\User;
use App\Mail\ResetMail;
use App\Http\Controllers\Controller;
use App\Services\ApiResponseService;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use App\Http\Requests\Api\Admin\Account\Password\SendEmailRequest;
use App\Http\Requests\Api\Admin\Account\Password\ChangePasswordRequest;
use App\Http\Requests\Api\Admin\Account\Password\CheckResetCodeRequest;
use Illuminate\Support\Facades\URL;


class PasswordAdminController extends Controller
{

  public function sendEmail(SendEmailRequest $request)
  {
    $user = User::where("email", $request->email)->first();
    if (!$user)
      return ApiResponseService::errorMsgResponse();
    $token = auth("reset_user_password")->login($user);
    // Create Reset Code
    $reset_code = rand(100000, 999999);
    $user->reset_code = Hash::make($reset_code);
    $user->save();
    // Send Mail
    Mail::to($request->email)->send(new ResetMail($reset_code)); //1 is admin
    // Response
    return ApiResponseService::successResponse(['token' => $token], trans("user.the Email Was Send To You Successfully"));
  }

  public function checkResetCode(Request $request) // we don't use CheckResetCodeRequest because I checked it in functin
  {
    $user = auth('reset_user_password')->user();
    if (!$user)
      return ApiResponseService::errorMsgResponse();
    if (Hash::check($request["reset_code"], $user->reset_code)) {
      $user->reset_code = "ok";
      $user->save();
      $messages['message'] = trans("user.the code is correct");
      $messages['token'] = '200';
      return ApiResponseService::successResponse($messages);
    } else {
      return ApiResponseService::errorMsgResponse("user.Code is not correct");
    }
  }

  public function changePassword(ChangePasswordRequest $request)
  {
    // $request->validate(['password' => 'required']);
    // $validator = Validator::make($request->all(), [
    //   'password' => ["required", "min:8"]
    // ]);
    // if ($validator->fails()) {
    //   return ApiResponseService::errorMsgResponse($validator->errors());
    // }

    $user = auth('reset_user_password')->user();
    if ($user && $user->reset_code == 'ok') {
      $user->password = Hash::make($request->password);
      $user->reset_code = '';
      $user->save();
      auth('reset_user_password')->logout();
      return ApiResponseService::successResponse(['user' => $user], 'the password was updated successfully');
    } else
      return ApiResponseService::unauthorizedResponse('Verification code must be entered first');
  }

  // Signed Route
  public function signedSendEmail(SendEmailRequest $request)
  {
    $user = User::where("email", $request->email)->first();
    if (!$user)
      return ApiResponseService::errorMsgResponse();
    $SignedUrl = URL::temporarySignedRoute(
      'signed.check-reset-code',
      now()->addMinutes(30)
    );
    // Create Reset Code
    $reset_code = rand(100000, 999999);
    $user->reset_code = Hash::make($reset_code);
    $user->save();
    // Send Mail
    Mail::to($request->email)->send(new ResetMail($reset_code, $SignedUrl));
    // Response
    return ApiResponseService::successResponse(['SignedUrl' => $SignedUrl], trans("user.the Email Was Send To You Successfully"));
  }

  public function signedCheckResetCode(Request $request)
  {
    $user = User::where("email", $request->email)->first();
    if (!$user)
      return ApiResponseService::errorMsgResponse();
    if (Hash::check($request["reset_code"], $user->reset_code)) {
      $user->reset_code = "ok";
      $user->save();
      $messages['message'] = trans("user.the code is correct");
      $messages['token'] = '200';
      return ApiResponseService::successResponse($messages);
    } else {
      return ApiResponseService::errorMsgResponse("user.Code is not correct");
    }
  }

  public function signedChangePassword(ChangePasswordRequest $request)
  {
    $user = User::where("email", $request->email)->first();
    if ($user && $user->reset_code == 'ok') {
      $user->password = Hash::make($request->password);
      $user->reset_code = '';
      $user->save();
      return ApiResponseService::successResponse(['user' => $user], 'the password was updated successfully');
    } else
      return ApiResponseService::unauthorizedResponse('Verification code must be entered first');
  }
}
