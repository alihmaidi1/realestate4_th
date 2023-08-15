<?php

use App\Models\User;
use App\Notifications\NewPost;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Notification;

if (!function_exists('tokenInfo')) {
  function tokenInfo($email, $password, $provider)
  {
    $client = DB::table('oauth_clients')->where("provider", $provider)->first();
    return Http::asForm()->post(env("APP_URL") . "/oauth/token", [
      'grant_type' => 'password',
      'client_id' => $client->id,
      'client_secret' => $client->secret,
      'username' => $email,
      'password' => $password,
    ]);
  }
}

if (!function_exists('refreshToken')) {
  function refreshToken($refreshToken, $provider = 'admins')
  {
    $client = DB::table('oauth_client')->where('provider', $provider)->first();
    return  Http::asForm()->post(env("APP_URL") . "/oauth/token", [
      'grant_type' => 'refresh_token',
      'refresh_token' => $refreshToken,
      'client_id' => $client->id,
      'client_secret' => $client->secret,
    ]);
  }
}

if (!function_exists('uploadImage')) {
  function uploadImage($image, $folder, $diskName = "local")
  {
    $filename = time() . rand(0, 9999999) . "." . $image->getClientOriginalExtension();
    Storage::disk('local')->put($folder . '/' . $filename, file_get_contents($image));
    $path = '/storage/' . $folder . '/' . $filename;
    return $path;
  }
}

if (!function_exists('uploadFile')) {
  function uploadFile($file, $folder, $diskName = "local")
  {
    $extension = $file->getClientOriginalExtension();
    $fileName = str_replace('.' . $extension, '', $file->getClientOriginalName()); //file name without extenstion
    $fileName .= '_' . md5(time()) . '.' . $extension; // a unique file name
    Storage::disk($diskName)->put($folder . '/' . $fileName, file_get_contents($file));
    return $fileName;
  }
}

if (!function_exists('aauth')) {
  function aauth()
  {
    return auth('api_user')->user();
  }
}

if (!function_exists('notifyUsers')) {
  function notifyUsers($area_id)
  {
    $users = User::all();
    Notification::send($users, new NewPost($area_id));
  }
}
