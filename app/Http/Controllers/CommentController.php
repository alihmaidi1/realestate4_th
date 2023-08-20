<?php

namespace App\Http\Controllers;

use App\Events\ChatMessageWasReceived;
use App\Events\Message;
use App\Models\Comment;
use Illuminate\Http\Request;
use App\Notifications\MyEvent;

use App\Services\ApiResponseService;
use App\Http\Resources\User\Comment\CommentsResource;
use App\Http\Resources\User\Comment\IndexCommentResource;
use Illuminate\Support\Facades\Notification;

class CommentController extends Controller
{
  public function __construct()
  {
    // $this->middleware('can:comment');
  }
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    return ApiResponseService::successResponse(['comments' =>  CommentsResource::collection(Comment::where('parent_id', null)->get())]);
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    //
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    try {
      $comment = Comment::create([
        // 'user_id' => $request->user_id,
        'user_id' => aauth()->id,
        'post_id' => $request->post_id,
        'parent_id' => $request->parent_id,
        'content' => $request->content,
      ]);

      // Send realtime event to all users
      event(new Message($request->content, aauth()->name));

      return ApiResponseService::successResponse(["comment" => new CommentsResource($comment)]);
    } catch (\Throwable $th) {
      return ApiResponseService::errorMsgResponse($th->getMessage());
    }
  }

  /**
   * Display the specified resource.
   */
  public function show($comment)
  {
    $comment = Comment::find($comment);
    if ($comment) {
      return ApiResponseService::successResponse(['comment' => new CommentsResource($comment->load('replys'))]);
    } else {
      return ApiResponseService::notFoundResponse();
    }
  }

  public function update(Request $request, $comment)
  {
    try {
      $comment = Comment::findOrFail($comment);
      $comment->update([
        'content' => $request->content,
      ]);

      return ApiResponseService::successResponse(["comment" => new CommentsResource($comment)]);
    } catch (\Throwable $th) {
      return ApiResponseService::notFoundResponse();
      // return ApiResponseService::errorMsgResponse($th->getMessage());
    }
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy($comment)
  {
    $comment = Comment::find($comment);
    if (!$comment)
      return ApiResponseService::notFoundResponse();
    $comment->delete();
    return ApiResponseService::successMsgResponse();
  }

  function commentOfPost($postId)
  {
    return ApiResponseService::successResponse(['comments' =>  CommentsResource::collection(Comment::where('parent_id', null)->where('post_id', $postId)->get())]);
  }
}
