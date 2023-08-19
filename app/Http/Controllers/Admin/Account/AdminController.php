<?php

namespace App\Http\Controllers\Admin\Account;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\ApiResponseService;
use App\Http\Resources\User\UserResource;
use App\Notifications\BlockUserNotification;
use Illuminate\Support\Facades\Notification;
use App\Repository\Interfaces\AdminRepoInterface;
use App\Http\Requests\Api\Admin\Operations\CreateAdminRequest;
use App\Http\Requests\Api\Admin\Operations\DeleteAdminRequest;
use App\Http\Requests\Api\Admin\Operations\UpdateAdminRequest;
use App\Http\Controllers\Admin\Account\Auth\EmailVerificationController;

class AdminController extends Controller
{
  protected $UserRepoInterface;
  public function __construct(AdminRepoInterface $UserRepoInterface)
  {
    // $this->middleware('can:admin')->except('admin_profile');
    $this->UserRepoInterface = $UserRepoInterface;
  }

  public function userProfile()
  {
    return ApiResponseService::successResponse(['authenticated-user' => new UserResource(aauth())]);
  }

  public function index()
  {
    return ApiResponseService::successResponse(['users' => UserResource::collection($this->UserRepoInterface->getAllUsers())]);
  }

  public function show($id)
  {
    $user = $this->UserRepoInterface->get($id, true);
    if ($user) {
      return ApiResponseService::successResponse(['user' => new UserResource($user)]);
    } else {
      return ApiResponseService::notFoundResponse();
    }
  }

  public function create(CreateAdminRequest $request)
  {
    $user = $this->UserRepoInterface->create($request->validated());

    return (new EmailVerificationController)->verification($user->id);
    // return redirect("/verification/" . $user->id);
    // return ApiResponseService::successResponse(['user' => $this->UserRepoInterface->create($request->validated())]);
  }

  public function update(UpdateAdminRequest $request)
  {
    $user = $this->UserRepoInterface->update($request->validated());
    if ($request->image) {
      $user->image_path = uploadImage($request["image"], 'users/' . $user->id, 'attachments');
      $user->save();
    }
    return ApiResponseService::successResponse(['user' =>  new UserResource($user)]);
  }

  public function delete(DeleteAdminRequest $request)
  {
    $user = $this->UserRepoInterface->delete($request->id);
    if ($user)
      return ApiResponseService::successResponse(['user' => new UserResource($user)]);
    else
      return ApiResponseService::notFoundResponse();
  }

  public function getAllPermissions()
  {
    $arr = config("global.permissions");
    $lang = Config('app.locale');
    $keys = [];
    $values = [];
    foreach ($arr as $key => $value) {
      $keys[] = $key;
      $values[] = $value[$lang];
    }
    $res['key'] = $keys;
    $res['value'] = $values;
    return ApiResponseService::successResponse(['permissions' => $res]);
  }

  public function MarkAsRead_All()
  {
    aauth()->unReadNotifications->markAsRead();
    return ApiResponseService::successMsgResponse();
  }

  // Mark the notification as read
  public function MarkAsRead_notification($notificationId)
  {
    $notification = aauth()->unReadNotifications->find($notificationId);
    if (!$notification)
      return ApiResponseService::notFoundResponse();
    $notification->markAsRead();
    return ApiResponseService::successMsgResponse();
  }

  function userBlock(Request $request)
  {
    $user = User::find($request->id);
    if (!$user)
      return ApiResponseService::notFoundResponse("هذا المستخدم غير موجود");
    $user->update(['status' => false]);
    Notification::send($user, new BlockUserNotification());
    return ApiResponseService::successMsgResponse("تم حظر المستخدم بنجاح");
  }
}
