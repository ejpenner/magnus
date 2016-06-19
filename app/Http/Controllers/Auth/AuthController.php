<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Profile;
use App\Gallery;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Permission;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware($this->guestMiddleware(), ['except' => 'logout']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:40',
            'username' => 'required|max:32|min:3|unique:users',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:8|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'username' => $data['username'],
            'slug' => str_slug($data['username']),
            'email' => $data['email'],
            'permission_id' => Permission::where('schema_name', 'User')->value('id'),
            'password' => bcrypt($data['password']),
            'timezone' => 'US\Central'
        ]);

        $user->profile()->save(new Profile(['biography'=>'Not filled out yet']));
        //$user->galleries()->save(new Gallery(['main_gallery'=>1, 'name'=>'Main Gallery']));

        return $user;
    }

    public function logout()
    {
        Session::flush();
        Auth::logout();
        return redirect('/login')->with('success', 'Successfully Logged Out!');
    }
}
