<?php

namespace App\Http\Middleware;

use App\Services\ApiResponseService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiPassword
{
  /**
   * Handle an incoming request.
   *
   * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
   */
  public function handle(Request $request, Closure $next): Response
  {
    if ($request->header("ApiPassword") == (env("api_password") ? env("api_password") : 'property_bashar'))
      return $next($request);
    else
      return ApiResponseService::unauthorizedResponse("you must inter correct password to api :)");
  }
}
