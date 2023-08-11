<?php

namespace App\Http\Controllers;

use App\Models\Information;
use Illuminate\Http\Request;
use App\Services\ApiResponseService;
use App\Http\Resources\User\Information\InformationResource;
use App\Http\Requests\Api\Admin\Information\CreateInformationRequest;

class InformationController extends Controller
{
  public function index()
  {
    return ApiResponseService::successResponse(['informations' => InformationResource::collection(Information::get())]);
  }

  public function store(CreateInformationRequest $request)
  {
    $information =  Information::create([
      "name" => $request->name,
      "code" => $request->code,
      "category_id" => $request->category_id,
    ]);
    return ApiResponseService::successResponse(['information' => new InformationResource($information)]);
  }

  public function show(Information $information)
  {
    if ($information) {
      return ApiResponseService::successResponse(['information' => new InformationResource($information)]);
    } else {
      return ApiResponseService::notFoundResponse();
    }
  }

  public function update(Request $request, $information)
  {

    $information = Information::find($information);
    if ($information) {
      $information->update([
        "name" => $request->name,
        "code" => $request->code,
        "category_id" => $request->category_id,
      ]);
      return ApiResponseService::successResponse(['information' =>  new InformationResource($information)]);
    } else
      return ApiResponseService::notFoundResponse();
  }

  public function destroy($information)
  {
    $information = Information::find($information);
    if ($information) {
      $information->delete();
      return ApiResponseService::successMsgResponse();
    } else
      return ApiResponseService::notFoundResponse();
  }
}
