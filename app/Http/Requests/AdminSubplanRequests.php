<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminSubplanRequests extends FormRequest
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
            'name'=>'required',
            'duration'=>'required|min:1',
            'features'=>'required',
            'price'=>'required',
            'photo'=>'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required'=>'Name cannot be empty',
            'duration.min'=>'Duration cannot be less than 1 month',
            'features.required'=>'Features cannot be empty',
            'price.required'=>'Price cannot be empty',
            'photo.required'=>'Picture is not selected',
        ];
    }
}
