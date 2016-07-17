<?php

namespace Magnus\Http\Requests;

use Magnus\Permission;
use Magnus\Http\Requests\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
        ];
    }
}
