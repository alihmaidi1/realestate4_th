<?php

namespace App\Http\Controllers\Admin\Account\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\EmailVerification;
use App\Http\Controllers\Controller;
use App\Services\ApiResponseService;
use Illuminate\Support\Facades\Mail;

class EmailVerificationController extends Controller
{
  public function sendOtp($user)
  {
    $otp = rand(100000, 999999);
    $time = time();

    EmailVerification::updateOrCreate(
      ['email' => $user->email],
      [
        'email' => $user->email,
        'otp' => $otp,
        'created_at' => $time
      ]
    );

    $data['email'] = $user->email;
    $data['title'] = 'Mail Verification';

    $data['body'] = 'Your OTP is:- ' . $otp;

    Mail::send('mailVerification', ['data' => $data], function ($message) use ($data) {
      $message->to($data['email'])->subject($data['title']);
    });
  }

  public function verification($id)
  {
    $user = User::where('id', $id)->first();
    if (!$user || $user->is_verified == 1) {
      return ApiResponseService::successResponse('alredy verified');
    }
    $email = $user->email;

    $this->sendOtp($user); //OTP SEND
    return ApiResponseService::successResponse('OTP has been sent to ' . $email);
  }

  public function verifiedOtp(Request $request)
  {
    $otpData = EmailVerification::where('email', $request->email)->where('otp', $request->otp)->first();
    if (!$otpData) {
      return response()->json(['success' => false, 'msg' => 'You entered wrong OTP']);
    } else {

      $currentTime = time();
      $time = $otpData->created_at;

      if ($currentTime >= $time && $time >= $currentTime - (60 * 10 + 5)) { //600 seconds
        User::where('email', $request->email)->update([
          'is_verified' => 1
        ]);
        $otpData->delete();
        // return ApiResponseService::successResponse('Mail has been verified');
        $user = User::where('email', $request->email)->first();
        $user->user_login_token = $user->createToken('MyApp')->plainTextToken;
        return ApiResponseService::successResponse(['user' => $user]);
      } else {
        return ApiResponseService::errorMsgResponse('Your OTP has been Expired');
      }
    }
  }

  public function resendOtp(Request $request)
  {
    $user = User::where('email', $request->email)->first();
    $otpData = EmailVerification::where('email', $request->email)->first();
    if (!$user)
      return ApiResponseService::successResponse('You entered wrong email');
    if ($user->is_verified || !$otpData)
      return ApiResponseService::successResponse('alredy verified');

    $currentTime = time();
    $time = $otpData->created_at;

    if ($currentTime >= $time && $time >= $currentTime - (90 + 5)) { //90 seconds
      return ApiResponseService::errorMsgResponse('Please try after some time');
    } else {
      $this->sendOtp($user); //OTP SEND
      return ApiResponseService::successResponse('resent OTP');
    }
  }
}
