<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Information;
use Illuminate\Http\Request;
use App\Services\ApiResponseService;
use App\Http\Resources\User\Category\CategoryResource;
use Illuminate\Support\Facades\File;

class CategoryController extends Controller
{
  public function index()
  {
    // delete posts from the category
    return ApiResponseService::successResponse(['catecories' => CategoryResource::collection(Category::get())]);
  }

  public function create(Request $request)
  {
    $Category =  Category::create([
      "name" => $request->name,
      "image_url" => $request->image_url ? uploadImage($request->image_url, 'categories', 'attachments') : null,
      "description" => $request->description
    ]);
    if ($request->informations) {
      foreach (json_decode($request->informations) as $value) {
        $Category->informations()->create([
          "name" => $value,
        ]);
      }
    }
    return ApiResponseService::successResponse(['Category' => $Category->load('informations')]);
  }

  public function show(Category $Category)
  {
    if ($Category) {
      return ApiResponseService::successResponse(['Category' => new CategoryResource($Category->load('informations'))]);
    } else {
      return ApiResponseService::notFoundResponse();
    }
  }

  public function update(Request $request, $Category)
  {
    $Category = Category::find($Category);
    if ($Category) {
      $Category->update([
        "name" => $request->name,
        "description" => $request->description
      ]);
      if ($request->hasFile("image_url")) {
        //CHECK IF FILE IS EXISTS
        if (($Category->image_url)) {
          unlink($Category->image_url);
        }
        $Category->image_url = uploadImage($request->image_url, 'categories', 'attachments');
        $Category->save();
      }
      return ApiResponseService::successResponse(['Category' => new CategoryResource($Category)]);
    } else
      return ApiResponseService::notFoundResponse();
  }

  public function delete($Category)
  {
    $Category = Category::find($Category);
    if ($Category) {
      if (File::exists(public_path($Category->image_url))) {
        unlink($Category->image_url);
      }
      $Category->delete();
      return ApiResponseService::successMsgResponse();
    } else
      return ApiResponseService::notFoundResponse();
  }
}
