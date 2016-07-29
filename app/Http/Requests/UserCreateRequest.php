<?php

namespace Magnus\Http\Requests;

use Magnus\Permission;
use Magnus\Http\Requests\Request;
use Illuminate\Support\Facades\Auth;

class UserCreateRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Permission::hasPermission(Auth::user(), ['admin_user_mgmt']);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'=>'required|min:3|max:40',
            'username'=>'required|min:3|unique:users|max:24',
            'email'=>'required|unique:users|email',
            'password' => 'required|min:8|confirmed',
            'password_confirmation' => 'required'
        ];
    }
}
