<?php

namespace Magnus\Http\Requests;

use Magnus\Permission;
use Illuminate\Support\Facades\Auth;
use Magnus\Http\Requests\Request;

class OpusCreateRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Permission::hasPermission(Auth::user(), ['user_opus_permission', 'admin_opus_permission']);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'image' => 'required|mimes:jpeg,bmp,png',
            'title' => 'required|min:3|max:60',
            'comment' => 'max:2000'
        ];
    }
}
