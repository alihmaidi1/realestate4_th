<?php

namespace App\Http\Requests\Api\Admin\Account\Password;

use Illuminate\Http\Response;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Exceptions\HttpResponseException;

class CheckResetCodeRequest extends FormRequest
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
      "reset_code" => "required|exists:users,reset_code"
    ];
  }

  protected function failedValidation(Validator $validator)
  {
    throw (new ValidationException($validator))
      ->errorBag($this->errorBag)
      ->redirectTo($this->getRedirectUrl())
      ->status(Response::HTTP_FORBIDDEN);
  }
}
