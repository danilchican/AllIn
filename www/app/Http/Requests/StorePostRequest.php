<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
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
            'is_plan' => 'boolean|required',
            'date' => 'date_format:"Y-m-d H:i"',
            'socials' => 'required|array',
            'socials.*.id' => 'distinct|exists:user_social_account|integer',
            'body' => 'required|max:4000'
        ];
    }
}
