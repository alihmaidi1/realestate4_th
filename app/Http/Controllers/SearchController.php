<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Services\ApiResponseService;
use App\Http\Resources\User\post\indexpostResource;

class SearchController extends Controller
{
  /**
   * Handle the incoming request.
   */
  public function __invoke(Request $request)
  {
    try {
      $posts = Post::query()
        ->select('posts.*')
        ->join('areas', 'posts.area_id', '=', 'areas.id')
        ->join('cities', 'areas.city_id', '=', 'cities.id')
        ->join('countries', 'cities.country_id', '=', 'countries.id')
        ->where(function ($q) use ($request) {
          $q->where('areas.name', 'like', '%' . $request->text . '%')
            ->orWhere('cities.name', 'like', '%' . $request->text . '%')
            ->orWhere('countries.name', 'like', '%' . $request->text . '%');
        })
        ->where('posts.available', '=', 1)
        ->get();

      $user_post_favorite = aauth()->favorite_posts;
      foreach ($posts as $post) {
        $post->is_favorite = false;
        foreach ($user_post_favorite as $user_post) {
          if ($user_post->id == $post->id) {
            $post->is_favorite = true;
            break;
          }
        }
      }

      return ApiResponseService::successResponse(['posts' =>  indexpostResource::collection($posts)]);
    } catch (\Throwable $th) {
      return ApiResponseService::errorMsgResponse($th->getMessage());
    }
  }
}
