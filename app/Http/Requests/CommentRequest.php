<?php

namespace Magnus\Http\Requests;

use Magnus\Permission;
use Magnus\Http\Requests\Request;
use Illuminate\Support\Facades\Auth;

class CommentRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Permission::hasPermission(Auth::user(), ['user_comment_permission', 'admin_comment_permission']);
    }

    /**
     * Return to the comment input area for top level comments
     * @param array $errors
     * @return $this
     */
    public function response(array $errors)
    {
        return redirect()->to(app('url')->previous() . '#replyTop')->withErrors($errors)->withInput();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'body' => 'required|min:3|max:3000'
        ];
    }
}
