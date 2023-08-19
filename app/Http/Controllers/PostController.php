<?php

namespace App\Http\Controllers;

use App\Http\Requests\Api\Admin\Post\StoreRequest;
use App\Http\Resources\User\post\indexpostResource;
use App\Models\Category;
use App\Models\Location\City;
use App\Models\Location\Country;
use App\Models\Post;
use App\Models\PostUser;
use Illuminate\Http\Request;
use App\Services\ApiResponseService;


class PostController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    try {
      // $user_id = aauth()->id;
      // $posts = Post::query()
      //   ->select('posts.*', DB::raw('(CASE WHEN post_user.user_id IS NOT NULL THEN true ELSE false END) as is_favorite'))
      //   ->leftJoin('post_user', function ($join) use ($user_id) {
      //     $join->on('posts.id', '=', 'post_user.post_id')
      //       ->where('post_user.user_id', '=', $user_id);
      //   })
      //   ->get();

      $posts_with_favorites = Post::where('available', true)->get();
      $user_post_favorite = aauth()->favorite_posts;
      foreach ($posts_with_favorites as $post) {
        $post->is_favorite = false;
        foreach ($user_post_favorite as $user_post) {
          if ($user_post->id == $post->id) {
            $post->is_favorite = true;
            break;
          }
        }
      }
      return ApiResponseService::successResponse(['posts' =>  indexpostResource::collection($posts_with_favorites)]);
    } catch (\Throwable $th) {
      return ApiResponseService::errorMsgResponse($th->getMessage());
    }
  }

  public function store(StoreRequest $request)
  {
    try {
      $post = Post::create([
        'user_id' => aauth()->id,
        'area_id' => $request->area_id,
        'category_id' => $request->category_id,
        'longitude' =>  $request->longitude,
        'latitude' =>  $request->latitude,
        'description' => $request->description,
        'available' => $request->available,
      ]);
      $post->update([
        'image_main' => uploadImage($request->imageMain, 'posts/' . $post->id, 'attachments')
      ]);

      foreach (json_decode($request->informationsId) as $key => $id) {
        $post->informations()->attach([$id => [
          'value' => json_decode($request->informationsVal)[$key],
        ]]);
      }

      // Handle image uploads
      if ($request->hasFile('images')) {
        foreach ($request->file('images') as $image) {
          $path = uploadImage($image, 'posts/' . $post->id, 'attachments');
          // Create a new image record and associate it with the post
          $post->images()->create([
            'path' => $path,
          ]);
        }
      }

      $post->types()->attach([$request->typeId => [
        'price'      => 10,
        'start_date' => now(),
        'end_date'   => now(),
      ]]);


      // Send notification to all users
      notifyUsers($request->area_id);

      return ApiResponseService::successResponse(["post" => new indexpostResource($post)]);
    } catch (\Throwable $th) {
      return ApiResponseService::errorMsgResponse($th->getMessage());
    }
  }

  /**
   * Display the specified resource.
   */
  public function show($post)
  {
    $post = Post::find($post);
    if ($post) {
      return ApiResponseService::successResponse(['post' => new indexpostResource($post)]);
    } else {
      return ApiResponseService::notFoundResponse();
    }
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, $id = null)
  {
    try {
      $post_data = [
        'area_id' => $request->area_id,
        'category_id' => $request->category_id,
        'longitude' => $request->longitude,
        'latitude' => $request->latitude,
        'description' => $request->description,
        'available' => $request->available,
      ];

      if ($id) {
        $post = Post::findOrFail($id);
        $post->update($post_data);
      } else {
        $post_data['user_id'] = auth()->user()->id;
        $post = Post::create($post_data);
      }

      $informations_data = collect($request->informations)->mapWithKeys(function ($info) {
        return [$info['id'] => ['value' => $info['value']]];
      })->toArray();

      $types_data = collect($request->types)->mapWithKeys(function ($type) {
        return [$type['id'] => [
          'price' => $type['price'],
          'start_date' => $type['start_date'],
          'end_date' => $type['end_date'],
        ]];
      })->toArray();

      $post->informations()->sync($informations_data);
      $post->types()->sync($types_data);

      return ApiResponseService::successResponse(['post' => new indexpostResource($post)]);
    } catch (\Throwable $th) {
      return ApiResponseService::errorMsgResponse($th->getMessage());
    }
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy($id)
  {
    $post = Post::find($id);
    if ($post) {
      $post->delete();
      return ApiResponseService::successMsgResponse();
    } else
      return ApiResponseService::notFoundResponse();
  }

  function postsOfCategory($categoryId)
  {
    $posts = Post::where('category_id', $categoryId)->get();
    return ApiResponseService::successResponse(['posts' => indexpostResource::collection($posts)]);
  }

  function postsOfLocation(Request $request)
  {
    $country_id = $request->country_id;
    $city_id = $request->city_id;
    $area_id = $request->area_id;
    $posts = Post::whereHas('area', function ($query) use ($country_id, $city_id, $area_id) {
      if ($country_id) {
        $query->whereHas('city', function ($query) use ($country_id) {
          $query->where('country_id', $country_id);
        });
      }
      if ($city_id) {
        $query->where('city_id', $city_id);
      }
      if ($area_id) {
        $query->where('id', $area_id);
      }
    })
      ->get();

    return ApiResponseService::successResponse(['posts' => indexpostResource::collection($posts)]);
    // return ApiResponseService::successResponse(['posts' => $posts]);
  }

  function updateFavoritePost(Request $request)
  {
    $user = $request->user();
    $post = Post::find($request->post_id);
    if (!$post)
      return ApiResponseService::notFoundResponse();
    if ($request->is_favorite) {
      $user->favorite_posts()->attach($request->post_id);
      return ApiResponseService::successMsgResponse("تم الاضافة الى قائمة المفضلة");
    }
    $user->favorite_posts()->detach($request->post_id);
    return ApiResponseService::successMsgResponse("تم الحذف من قائمة المفضلة");
  }

  function favoritePost()
  {
    $posts = aauth()->favorite_posts;
    foreach ($posts as $post) {
      $post->is_favorite = true;
    }
    return ApiResponseService::successResponse(['posts' => indexpostResource::collection($posts)]);
  }

  function accept(Request $request)
  {
    $post = Post::find($request->postId);
    if (!$post)
      return ApiResponseService::notFoundResponse('هذا البوست غير موجود');
    $post->available = true;
    $post->save();
    return ApiResponseService::successMsgResponse("تم الموافقة على المنشور");
  }

  function pendingPost()
  {
    $posts = Post::where('available', false)->get();
    $posts_count = count($posts);
    return ApiResponseService::successResponse(['posts_coun' => $posts_count, 'posts' => indexpostResource::collection($posts)]);
  }
}
