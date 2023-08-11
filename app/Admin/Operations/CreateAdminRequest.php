<?php

namespace App\Http\Requests\Api\Admin\Operations;

use Illuminate\Foundation\Http\FormRequest;

class CreateAdminRequest extends FormRequest
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
      "name" => "required",
      "phone" => "required",
      "email" => "required|email",
      "password" => "required|min:8",
      "role_id" => "required|exists:roles,id",
    ];
  }
}
