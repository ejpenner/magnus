<?php

namespace Magnus\Http\Controllers\Auth;

use Magnus\User;
use Magnus\Role;
use Magnus\Profile;
use Magnus\Gallery;
use Magnus\Preference;
use Magnus\Helpers\Helpers;
use Illuminate\Support\Facades\Auth;
use Magnus\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
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
            'password' => bcrypt($data['password']),
            'timezone' => 'America/Chicago'
        ]);

        $userRole = Role::where(['role_code' => config('roles.user-code')])->value('id');
        $user->roles()->attach($userRole);
        $user->profile()->save(new Profile(['biography'=>'Not filled out yet']));
        $user->preferences()->save(new Preference(['sex' => '', 'show_sex' => 0, 'date_of_birth' => '0000-00-00', 'show_dob' => 'none', 'per_page' => 24]));
        Gallery::makeDirectories($user);

        return $user;
    }

    public function logout()
    {
        Session::flush();
        Auth::logout();
        return redirect('/login')->with('success', 'Successfully Logged Out!');
    }
}
