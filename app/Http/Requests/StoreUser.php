<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUser extends FormRequest
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
            'fName' => 'required|string|min:2',
            'mName' => 'required|string|min:2',
            'lName' => 'required|string|min:2',
            'uname' => 'required|unique:users|string|min:4',
            'email' => 'required|email',
            'store_id' => 'required|numeric',
            'role_id' => 'required|numeric',
            'position_id' => 'required|numeric'
        ];
    }
}
