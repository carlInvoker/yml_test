<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GenerateFile extends FormRequest
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
          'name' => 'required|string|max:255',
          'price' => 'required|regex:/^\d+(\.\d{1,2})?$/',
          'image' => 'required|mimes:jpg,png|max:8192',
          'category' => 'required|string|max:255',
        ];
    }
}
