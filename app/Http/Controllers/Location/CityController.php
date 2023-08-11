<?php

namespace App\Http\Controllers\Location;

use Illuminate\Http\Request;
use App\Models\Location\City;
use App\Http\Controllers\Controller;
use App\Http\Resources\User\City\CityResource;
use App\Services\ApiResponseService;

class CityController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    return 'index: all city';
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    return 'create: create city';
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    return 'store: store city';
  }

  /**
   * Display the specified resource.
   */
  public function show(string $id)
  {
    return 'show: edit city';
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(string $id)
  {
    return 'edit: edit city';
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, string $id)
  {
    return 'update: update city';
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(string $id)
  {
    return 'destroy: destroy city';
  }

  function citiesOfCountry($countryId)
  {
    $cities = City::where('country_id', $countryId)->get();
    return ApiResponseService::successResponse(['cities' => CityResource::collection($cities)]);
  }
}
