<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTicket extends FormRequest
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
            'caller_id' =>  'required|numeric',
            'contact_id' =>  'required|numeric',
            'subject' =>  'required|string|max:255|min:10',
            'details' =>  'required|string|max:255|min:10',
            'attachments' => 'nullable|file',
            'type' =>  'required|numeric',
            'priority' => 'required|numeric',
            'category' => 'required|numeric',
            'catA' =>  'required|numeric',
            'catB' =>  'nullable|numeric',
            'expiration' => 'required' ,
            'assignee' =>'nullable'

        ];
    }
}
