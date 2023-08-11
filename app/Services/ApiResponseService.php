<?php


namespace App\Services;


class ApiResponseService
{
  public static function successResponse($data, $msg = null, $code = 200)
  {
    if (is_null($msg)) $msg = trans('messages.successfully');
    return response()->json(
      [
        'message' => trans('messages.successfully'),
        'success' => true,
        'data' => $data
      ],
      $code
    );
  }

  public static function validateResponse($errors, $code = 422)
  {
    return response()->json(
      [
        'message' => trans('messages.validation_error'),
        'success' => false,
        'errors' => $errors->all()
      ],
      $code
    );
  }

  public static function deletedResponse($msg = null, $code = 200)
  {
    if (is_null($msg)) $msg = trans('messages.deleted');
    return response()->json(
      [
        'message' => $msg,
        'success' => true,
        'data' => []
      ],
      $code
    );
  }

  public static function successMsgResponse($msg = null, $code = 200)
  {
    if (is_null($msg)) $msg = trans('messages.successfully');
    return response()->json(
      [
        'message' => $msg,
        'success' => true,
        'data' => []
      ],
      $code
    );
  }

  public static function notFoundResponse($msg = null, $code = 404)
  {
    if (is_null($msg)) $msg = trans('messages.not_found');

    return response()->json(
      [
        'message' => $msg,
        'success' => false,
        'errors' => [$msg]
      ],
      $code
    );
  }

  public static function unauthorizedResponse($msg = null, $code = 401)
  {
    return response()->json(
      [
        'message' => $msg ?? trans('messages.unauthorized'),
        'success' => false,
        'errors' => [$msg ?? trans('messages.unauthorized')]
      ],
      $code
    );
  }

  public static function errorMsgResponse($msg = null, $code = 400)
  {
    if (is_null($msg)) $msg = trans('messages.some_thing_went_wrong');

    return response()->json(
      [
        'message' => $msg,
        'success' => false,
        'errors' => [$msg]
      ],
      $code
    );
  }
}
