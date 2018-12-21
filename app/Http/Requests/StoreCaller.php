<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCaller extends FormRequest
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
            'store_id' => 'required|numeric'
        ];
    }

    public function attributes()
    {
        return [
            'fName' => 'First Name',
            'mName' => 'Middle Name',
            'lName' => 'Last Name',
            'store_id' => 'Branch',
        ];
    }
}
