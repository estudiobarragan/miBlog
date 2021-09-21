<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ApproveRequest extends FormRequest
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
    $approve = $this->request->all()['approved'];

    if ($approve == 0 || $approve == 1) {
      // Si cancela o graba
      $rules = [
        'level' => 'required',
        'timeToRead' => 'required',
        'linksSource' => 'required',
        'understandable' => 'required',
        'title' => 'required',
        'image' => 'required',
        'summary' => 'required',
        'conclusion' => 'required',
        'examples' => 'required',
        'tagRight' => 'required',
        'categoryRight' => 'required',
      ];
    } elseif ($approve == 2) {
      // Si aprueba

      $rules = [
        'level' => 'required',
        'timeToRead' => 'required|integer|gt:0',
        'linksSource' => 'required|accepted',
        'understandable' => 'required|accepted',
        'title' => 'required|accepted',
        'image' => 'required|accepted',
        'summary' => 'required|accepted',
        'conclusion' => 'required|accepted',
        'examples' => 'required|accepted',
        'tagRight' => 'required|accepted',
        'categoryRight' => 'required|accepted',
      ];
    } elseif ($approve == 3) {
      // Si rechaza
      $rules = [
        'level' => 'required',
        'timeToRead' => 'required',
        'linksSource' => 'required',
        'understandable' => 'required',
        'title' => 'required',
        'image' => 'required',
        'summary' => 'required',
        'conclusion' => 'required',
        'examples' => 'required',
        'tagRight' => 'required',
        'categoryRight' => 'required',
        'feedback' => 'required',
      ];
    }
    return $rules;
  }
}
