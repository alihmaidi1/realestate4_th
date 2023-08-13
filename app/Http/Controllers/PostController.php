<?php

namespace App\Http\Controllers;

use App\Http\Requests\Api\Admin\Post\StoreRequest;
use App\Http\Resources\User\post\indexpostResource;
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

      $posts_with_favorites = Post::get();
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

      foreach ($request->informations as $info) {
        $info = json_decode($info);
        $post->informations()->attach([$info->id => [
          'value' => $info->value,
        ]]);
      }
      // OR


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


      // foreach ($request->types as $type) {
      //   $type = json_decode($type);
      //   $post->types()->attach([$type->id => [
      //     'price'      => $type->price,
      //     'start_date' => $type->start_date,
      //     'end_date'   => $type->end_date,
      //   ]]);
      // }

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
}
