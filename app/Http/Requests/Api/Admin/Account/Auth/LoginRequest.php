<?php

namespace App\Http\Requests\Api\Admin\Account\Auth;

use App\Services\ApiResponseService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class LoginRequest extends FormRequest
{
  /**
   * Determine if the user is authorized to make this request.
   */
  public function authorize(): bool
  {
    return true;
  }

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
   */
  public function rules(): array
  {
    return [
      'email' => 'required|email|exists:users,email',
      'password' => ["required", "min:8"]
    ];
  }

  protected function failedValidation(Validator $validator)
  {
    if ($this->wantsJson()) {
      throw new HttpResponseException(
        ApiResponseService::errorMsgResponse($validator->errors()->first())
      );
    }
    parent::failedValidation($validator);
  }
}
