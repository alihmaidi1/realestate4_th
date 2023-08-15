<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Models\Review;
use Illuminate\Http\Request;
use App\Services\ApiResponseService;

class StatsController extends Controller
{
  /**
   * Handle the incoming request.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function __invoke(Request $request)
  {
    $stats['count_users'] = User::count();
    $stats['count_posts'] = Post::count();
    $stats['last3_users'] = User::last()->take('3')->get();
    $stats['last3_posts'] = Post::last()->take('3')->get();
    $stats['last3_suggestion'] = Review::last()->where('type', 'suggestion')->take('3')->get();
    $stats['last3_complaint'] = Review::last()->where('type', 'complaint')->take('3')->get(); //شكوى
    return ApiResponseService::successResponse($stats);
  }
}
