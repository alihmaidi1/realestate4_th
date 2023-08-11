<?php

namespace App\Http\Controllers\Location;

use Illuminate\Http\Request;
use App\Models\Location\Country;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Services\ApiResponseService;
use App\Http\Resources\User\Country\CountryResource;

class CountryController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    return ApiResponseService::successResponse(['country' => CountryResource::collection(Country::get())]);
  }


  public function create(Request $request)
  {
    DB::beginTransaction();

    try {

      // حفظ البيانات في جدول البلدان
      $country =  Country::create([
        "name" => $request->name,
      ]);

      // حفظ البيانات في جدول المدن
      foreach ($request->cities as $value) {
        $country->cities()->create([
          "name" => $value,
        ]);
      }

      DB::commit();
      return ApiResponseService::successResponse(['country' => new CountryResource($country)]);
    } catch (\Exception $e) {
      DB::rollback();
      return ApiResponseService::errorMsgResponse(['error' => $e->getMessage()]);
    }
  }

  /**
   * Display the specified resource.
   */
  public function show($id)
  {
    $country = Country::find($id);
    if ($country) {
      return ApiResponseService::successResponse(['country' => new CountryResource($country)]);
    } else {
      return ApiResponseService::notFoundResponse();
    }
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, string $id)
  {
    try {
      // تحديث البيانات في جدول البلدان
      $country =  Country::find($id);
      $country->update([
        "name" => $request->name,
      ]);
      return ApiResponseService::successResponse(['country' => new CountryResource($country)]);
    } catch (\Exception $e) {
      return ApiResponseService::errorMsgResponse(['error' => $e->getMessage()]);
    }
  }

  /**
   * Remove the specified resource from storage.
   */
  public function delete($id)
  {
    $country = Country::find($id);
    if ($country) {
      $country->delete();
      return ApiResponseService::successMsgResponse();
    } else
      return ApiResponseService::notFoundResponse();
  }
}
