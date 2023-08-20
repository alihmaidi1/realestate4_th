<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
  PostController,
  RoleController,
  TypeController,
  ReviewController,
  CommentController,
  CategoryController,
  ChatController,
  InformationController,
  SearchController,
  StatsController,
};
use App\Http\Controllers\Location\{
  AreaController,
  CityController,
  CountryController
};
use App\Http\Controllers\Admin\Account\AdminController;
use App\Http\Controllers\Admin\Account\Auth\AuthAdminController;
use App\Http\Controllers\Admin\Account\Auth\EmailVerificationController;
use App\Http\Controllers\Admin\Account\Auth\PasswordAdminController;
use App\Services\ApiResponseService;

use function GuzzleHttp\default_ca_bundle;

// ##### To Guest #####
Route::post('dashboard/login', [AuthAdminController::class, 'login'])->name('user.login')->middleware('is.verified');
// To Change Password
Route::post('send-email', [PasswordAdminController::class, 'sendEmail'])->name('send_email');
Route::post('check-reset-code', [PasswordAdminController::class, 'checkResetCode'])->name('check-reset-code');
Route::post('change-password', [PasswordAdminController::class, 'changePassword'])->name('change-password');

// Register
Route::post('users/create', [AdminController::class, 'create'])->name('create');
// Route::post('users/create', [AuthAdminController::class, 'register'])->name('create');
// To Verify Email
Route::get('/verification/{id}', [EmailVerificationController::class, 'verification']);
Route::post('/verified', [EmailVerificationController::class, 'verifiedOtp'])->name('verifiedOtp');
Route::get('/resend-otp', [EmailVerificationController::class, 'resendOtp'])->name('resendOtp');

// To Change Password With Signed URL
Route::post('signed/send-email', [PasswordAdminController::class, 'signedSendEmail'])->name('signed.send_email');
Route::get('signed/check-reset-code', [PasswordAdminController::class, 'signedCheckResetCode'])->middleware('signed')->name('signed.check-reset-code');
Route::post('signed/change-password', [PasswordAdminController::class, 'signedChangePassword'])->name('signed.change-password');

// ##### Must be auth #####
Route::prefix('dashboard')->middleware(['auth:sanctum', 'api.password'])->group(function () {
  // Logout
  Route::post('logout', [AuthAdminController::class, 'logout'])->name('logout');

  // Start Role
  Route::prefix('roles')->as("role.")->group(function () {
    Route::get('', [RoleController::class, 'index'])->name('index');
    Route::get('show/{id?}', [RoleController::class, 'show'])->name('show');
    Route::post('create', [RoleController::class, 'create'])->name('create');
    Route::post('update/{id?}', [RoleController::class, 'update'])->name('update');
    Route::delete('delete/{id?}', [RoleController::class, 'delete'])->name('delete');
  });

  // Start User (also Admin)
  Route::get('user-profile', [AdminController::class, 'userProfile'])->name('user-profile');

  Route::prefix('users')->as("user.")->group(function () {
    Route::get('', [AdminController::class, 'index'])->name('index');
    Route::get('show/{id?}', [AdminController::class, 'show'])->name('show');
    Route::post('update', [AdminController::class, 'update'])->name('update');
    Route::post('delete', [AdminController::class, 'delete'])->name('delete');
    //favorite posts
    Route::get('/favorite-posts', [PostController::class, 'favoritePost']);
    // Notification
    Route::post('notifications-markAsRead', [AdminController::class, 'MarkAsRead_All']);
    Route::post('notification-markAsRead/{notificationId?}', [AdminController::class, 'MarkAsRead_notification']);
  });

  // permissions
  Route::get('get-all-permissions', [AdminController::class, 'getAllPermissions'])->name('get-all-permissions');

  // Start Location
  Route::prefix('countries')->as("country.")->group(function () {
    Route::get('', [CountryController::class, 'index'])->name('index');
    Route::get('show/{id?}', [CountryController::class, 'show'])->name('show');
    Route::post('create', [CountryController::class, 'create'])->name('create');
    Route::post('update/{id?}', [CountryController::class, 'update'])->name('update');
    Route::delete('delete/{id?}', [CountryController::class, 'delete'])->name('delete');
  });
  Route::get('/cities-of-country/{countryId?}', [CityController::class, 'citiesOfCountry']);
  Route::resource('cities', CityController::class);
  Route::get('/areas-of-city/{cityId?}', [AreaController::class, 'areasOfCity']);
  Route::resource('area', AreaController::class);

  // search for countries, cities or areas
  Route::post('/posts-of-location', [PostController::class, 'postsOfLocation']);


  // Start Catecories
  Route::prefix('categories')->as("category.")->group(function () {
    Route::get('', [CategoryController::class, 'index'])->name('index');
    Route::get('show/{category?}', [CategoryController::class, 'show'])->name('show');
    Route::post('create', [CategoryController::class, 'create'])->name('create');
    Route::post('update/{catecory?}', [CategoryController::class, 'update'])->name('update');
    Route::delete('delete/{catecory?}', [CategoryController::class, 'delete'])->name('delete');
  });

  // Start Informations
  Route::post('information/update/{catecory?}', [InformationController::class, 'update']);
  Route::resource('information', InformationController::class);

  // Start Posts
  Route::post('/posts/create', [PostController::class, 'store']);

  Route::post('/posts/accept', [PostController::class, 'accept']);
  Route::get('/posts/pending', [PostController::class, 'pendingPost']);
  Route::get('/posts-of-category/{categoryId?}', [PostController::class, 'postsOfCategory']);
  Route::resource('post', PostController::class);

  // Start favorite Posts
  Route::post('/update-favorite-posts', [PostController::class, 'updateFavoritePost']);

  // Start Comments
  Route::get('/comments-of-post/{postId?}', [CommentController::class, 'commentOfPost']);
  Route::resource('comments', CommentController::class);

  // Start Types
  Route::resource('types', TypeController::class);

  // Start Review
  Route::resource('reviews', ReviewController::class);

  // Start Search
  Route::get('search', SearchController::class);

  // block User
  Route::post('user-block', [AdminController::class, 'userBlock'])->name('user-block');

  // stats
  Route::get('stats', StatsController::class);

  // Chats
  Route::post('chat', [ChatController::class, 'index']);
  Route::get('chat/users', [ChatController::class, 'users']);
  Route::post('chat/message', [ChatController::class, 'store']);
});

// ### Route 404 ###
Route::fallback(function () {
  return ApiResponseService::notFoundResponse("this url is not found");
});
