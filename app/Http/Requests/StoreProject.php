<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProject extends FormRequest
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
        $id=$this->route('project');
        return [
            'title'=>'required',
            'description'=>'required',
            'start_date'=>'required',
            'deadline'=>'required',
            'priority'=>'required',
            'status'=>'required'
        ];
    }
}
