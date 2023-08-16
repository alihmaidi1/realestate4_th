<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Events\ChatMessage;
use Illuminate\Http\Request;
use App\Services\ApiResponseService;
use App\Http\Resources\Chat\ChatResource;

class ChatController extends Controller
{
  function index(Request $request)
  {
    if (!$request->user_id) {
      return ApiResponseService::errorMsgResponse("user_id is required");
    }

    $messages = Chat::where(function ($query) use ($request) {
      $query->where('from_user', aauth()->id)->where('to_user', $request->user_id);
    })->orWhere(function ($query) use ($request) {
      $query->where('from_user', $request->user_id)->where('to_user', aauth()->id);
    })->orderBy('created_at', 'ASC')->get();

    return ApiResponseService::successResponse(["messages" => $messages]);
  }

  function store(Request $request)
  {
    try {
      $chat = Chat::create([
        'from_user' => aauth()->id,
        'to_user' => $request->to_user,
        'content' => $request->content,
      ]);

      // Send realtime event to all users
      event(new ChatMessage($request->content, aauth()->name));

      return ApiResponseService::successResponse(["chat" => $chat]);
    } catch (\Throwable $th) {
      return ApiResponseService::errorMsgResponse($th->getMessage());
    }
  }
}
