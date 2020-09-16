<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DoctorUpdateRequests extends FormRequest
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
            'phone'=>'required|max:11|min:11',
            'gender'=>'required',
            'license'=>'required',
            'qualifications'=>'required',
            'specialty'=>'required'
        ];
    }

    public function messages()
    {
        return [
            'name'=>'Name cannot be empty',
            'phone.required'=>'Phone number cannot be empty',
            'phone.max'=>'Phone number cannot be greater than 11 digits',
            'phone.min'=>'Phone number cannot be less than 11 digits',
            'gender.required'=>'Gender is not selected',
            'license.required'=>'License cannot be empty',
            'qualifications.required'=>'Qualifications cannot be empty',
            'specialty.required'=>'Specialty is not selected'
        ];
    }
}
