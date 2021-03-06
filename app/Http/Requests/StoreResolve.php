<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreResolve extends FormRequest
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
            'cause' => 'required|string|min:10|max:200',
            'resolution' => 'required|string|min:10|max:200',
            'recommendation' => 'required|string|min:10|max:200',
            'res_category' => 'required|numeric',
        ];
    }
}
