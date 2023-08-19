<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Review;
use Illuminate\Http\Request;
use App\Notifications\NewReview;
use App\Services\ApiResponseService;
use Illuminate\Support\Facades\Notification;
use App\Http\Resources\User\Review\ReviewResource;

class ReviewController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    return ApiResponseService::successResponse(['reviews' =>  Review::get()]);
    // return ApiResponseService::successResponse(['reviews' =>  ReviewResource::collection(Review::get())]);
  }


  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    try {
      $review = Review::create([
        // 'user_id' => $request->user_id,
        'user_id' => aauth()->id,
        'post_id' => $request->post_id ?? null,
        'title' => $request->title,
        'type' => $request->type,
      ]);

      // Send notification to admin
      Notification::send(User::first(), new NewReview($request->post_id));

      return ApiResponseService::successResponse(["review" => $review]);
    } catch (\Throwable $th) {
      return ApiResponseService::errorMsgResponse($th->getMessage());
    }
  }

  /**
   * Display the specified resource.
   */
  public function show($review)
  {
    $review = Review::find($review);
    if ($review) {
      // return ApiResponseService::successResponse(['review' => new ReviewResource($review)]);
      return ApiResponseService::successResponse(['review' => $review]);
    } else {
      return ApiResponseService::notFoundResponse();
    }
  }

  // public function update(Request $request, Review $review)
  // {
  //   try {
  //     $review = Review::findOrFail($review);
  //     $review->update([
  //       'user_id' => $request->user_id,
  //       'post_id' => $request->post_id,
  //       'title' => $request->title,
  //       'type' => $request->type,
  //     ]);

  //     // Send notification to admin
  //     // notifyUsers($request->area_id);

  //     return ApiResponseService::successResponse(["review" => new ReviewResource($review)]);
  //   } catch (\Throwable $th) {
  //     return ApiResponseService::errorMsgResponse($th->getMessage());
  //   }
  // }



  public function destroy($review)
  {
    $review = Review::find($review);
    if (!$review)
      return ApiResponseService::notFoundResponse();
    $review->delete();
    return ApiResponseService::successMsgResponse();
  }
}
