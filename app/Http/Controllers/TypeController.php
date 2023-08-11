<?php

namespace App\Http\Controllers;

use App\Models\Type;
use Illuminate\Http\Request;
use App\Services\ApiResponseService;
use App\Http\Resources\User\Type\TypeResource;

class TypeController extends Controller
{

  public function index()
  {
    return ApiResponseService::successResponse(['types' =>  TypeResource::collection(Type::get())]);
  }

  public function show($type)
  {
    $type = Type::find($type);
    if ($type) {
      return ApiResponseService::successResponse(['type' => new TypeResource($type)]);
    } else {
      return ApiResponseService::notFoundResponse();
    }
  }
}
