<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UpgradeUserController extends Controller
{
    // public function __constructor()
    // {
    //     $this->middleware('can:upgrad-user');
    // }

    public function silver($id)
    {
        try {
            // تحديث البيانات في جدول المستخدم واضافة 5 بوستات له
            $user = User::find($id);
            $user->max_post += 5;
            return ApiResponseService::successResponse(['user' => $user]);
            } catch (\Exception $e) {
            return ApiResponseService::errorMsgResponse(['error' => $e->getMessage()]);
        }
    }
    public function golden($id)
    {
        try {
            // تحديث البيانات في جدول المستخدم واضافة 5 بوستات له
            $user = User::find($id);
            $user->max_post += 10;
            return ApiResponseService::successResponse(['user' => $user]);
            } catch (\Exception $e) {
            return ApiResponseService::errorMsgResponse(['error' => $e->getMessage()]);
        }
    }
}
