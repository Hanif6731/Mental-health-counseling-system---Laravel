<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminAddstaffRequests extends FormRequest
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
            'email'=>'required',
            'password'=>'required',
            'type'=>'required',
            'status'=>'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required'=>'Name cannot be empty',
            'email.required'=>'Email cannot be empty',
            'password.required'=>'Password cannot be empty',
            'type.required'=>'User type cannot be empty',
            'status.required'=>'User status cannot be empty',
        ];
    }
}
