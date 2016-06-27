<?php

namespace Magnus\Http\Requests;

use Magnus\Http\Requests\Request;

class PasswordRequest extends Request
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
            'old_password' => 'required|min:8',
            'password' => 'required|min:8|confirmed|different:old_password',
            'password_confirmation' => 'required'
        ];
    }
}
