<?php

namespace Magnus\Http\Requests;

use Magnus\Permission;
use Magnus\Http\Requests\Request;
use Illuminate\Support\Facades\Auth;

class JournalRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; //Permission::hasPermission(Auth::user(), ['user_journal_permission', 'admin_journal_permission']);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|min:3|max:140',
            'rawBody' => 'min:3|max:5000|required'
        ];
    }
}
