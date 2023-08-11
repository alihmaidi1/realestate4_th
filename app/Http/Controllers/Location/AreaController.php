<?php

namespace App\Http\Controllers\Location;

use Illuminate\Http\Request;
use App\Models\Location\Area;
use App\Http\Controllers\Controller;
use App\Http\Resources\User\Area\AreaResource;
use App\Services\ApiResponseService;

class AreaController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    return 'index: all area';
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    return 'create: create area';
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    return 'store: store area';
  }

  /**
   * Display the specified resource.
   */
  public function show(string $id)
  {
    return 'edit: edit area';
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(string $id)
  {
    return 'edit: edit area';
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, string $id)
  {
    return 'update: update area';
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(string $id)
  {
    return 'destroy: destroy area';
  }

  function areasOfCity($cityId)
  {
    $areas = Area::where('city_id', $cityId)->get();
    return ApiResponseService::successResponse(['cities' => AreaResource::collection($areas)]);
  }
}
