<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EventRegistratinRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();

    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'user_id' => [
                'required_without:user_name'
            ],
            'user_name' => [
                'required_without:user_id'
            ],
            'tedad' => [
                'required' , 'numeric','min:1'
            ],
            'event_id'=>[
                'required'
            ]
        ];
    }
}
