<?php

namespace Magnus\Http\Requests;

use Magnus\Permission;
use Illuminate\Support\Facades\Auth;
use Magnus\Http\Requests\Request;

class GalleryRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Permission::hasPermission(Auth::user(), ['user_gallery_permission', 'admin_gallery_permission']);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|min:3|max:64',
            'description' => 'required'
        ];
    }
}
