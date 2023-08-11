<?php

namespace App\Http\Requests\Api\Admin\Information;

use Illuminate\Foundation\Http\FormRequest;

class CreateInformationRequest extends FormRequest
{
  /**
   * Determine if the user is authorized to make this request.
   *
   * @return bool
   */
  public function authorize()
  {
    return true;
  }

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function rules()
  {
    return [
      "name" => 'required',
      // "code" => 'required',
      // "row_num" => 'required|unique:information,row_num',
      // "type_row" => 'required',
      "category_id" => 'required|exists:categories,id',
    ];
  }
}
