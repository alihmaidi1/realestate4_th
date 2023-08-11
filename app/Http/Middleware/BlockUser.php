<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class BlockUser
{

  protected $requestsLimit = 3;
  protected $timeLimit = 60; // بالثواني

  protected $blockedIps = [];

  protected $blockTime = 60; // بالثواني
  /**
   * Handle an incoming request.
   *
   * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
   */
  public function handle(Request $request, Closure $next): Response
  {
    $ip = $request->ip();

    if (in_array($ip, $this->blockedIps)) {
      return response('Unauthorized', 401);
    }

    $requests = Cache::get($ip) ?? [];
    $requestTime = time();

    $requests[] = $requestTime;
    Cache::put($ip, $requests, $this->timeLimit);

    // number of requests is larger than limit
    if (count($requests) > $this->requestsLimit) {
      $timeDifference = $requestTime - $requests[0];
      // number of requests out of limit and out of time
      if ($timeDifference <= $this->timeLimit) {
        $blockedUntil = $requestTime + $this->blockTime;
        Cache::put($ip, [], $this->blockTime);
        return response('Unauthorized', 401)->header('X-Blocked-Until', $blockedUntil);
      }
      array_shift($requests);
      Cache::put($ip, $requests, $this->timeLimit);
    }

    return $next($request);
  }
}
