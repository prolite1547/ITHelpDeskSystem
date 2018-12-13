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
            'name' => 'required|unique:callers|string|min:10',
            'store_id' => 'required|numeric'
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'Caller',
            'store_id' => 'Branch',
        ];
    }
}
