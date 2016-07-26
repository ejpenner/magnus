<?php

namespace Magnus\Http\Requests;

use Magnus\Permission;
use Magnus\Http\Requests\Request;

class OpusEditRequest extends Request
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
            'title' => 'required|min:3|max:60',
            'image' => 'mimes:jpeg,bmp,png'
        ];
    }
}
