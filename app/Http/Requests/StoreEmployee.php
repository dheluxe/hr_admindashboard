<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEmployee extends FormRequest
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
            'employee_id'=>'required|unique:users,employee_id',
            'name'=>'required',
            'email'=>'required|unique:users,email',
            'phone'=>'required|min:8|max:11|unique:users,phone',
            'nrc_number'=>'required',
            'password'=>'required',
            'pin_code'=>'required|min:4|max:4|unique:users,pin_code',
            'gender'=>'required',
            'birthday'=>'required',
            'address'=>'required',
            'department_id'=>'required',
            'date_of_join'=>'required',
            'is_present'=>'required'
        ];
    }
}
