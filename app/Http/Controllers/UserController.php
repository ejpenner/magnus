<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;

use App\Http\Requests;

use App\User;
use App\Profile;
use App\Permission;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        
        foreach ($users as &$user) {
            $user->permission_id = Permission::where('id', $user->permission_id)->value('schema_name');
        }
        return view('user.index', compact('users'));
    }

    public function show(User $user)
    {
        //$user = User::where('id', $id)->first();
        $permissions = Permission::lists('schema_name', 'id');

        return view('user.edit', compact('user', 'permissions'));
    }

    public function create()
    {
        return view('user.create');
    }

    public function store(Requests\UserCreateRequest $request)
    {
        $user = new User;

        $user->username = $request->username;
        $user->name = $request->name;
        $user->profile_slug = str_slug($request->username, '-');
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->permission_id = $request->permission_id;
        $user->save();
        
        Profile::create(['user_id'=>$user->id]);
        
        return redirect()->route('users.index')->with('success', 'Your user was created.');
    }

    public function edit(User $user)
    {
        //$user = User::findOrFail($id);
        $permissions = Permission::lists('schema_name', 'id');

        return view('user.edit', compact('user', 'permissions'));
    }

    public function update(User $user, Requests\UserEditRequest $request)
    {
        //$user = User::findOrFail($id);
        if ($request->password == $request->password_confirmation) {
            $user->name = $request->name;
            $user->username = $request->username;
            $user->email = $request->email;
            $user->slug = str_slug($request->username, '-');
            if ($request->password != "" and $request->password != null) {
                $user->password = bcrypt($request->password);
            }
            $user->permission_id = $request->permission_id;

            $user->save();

            return redirect()->route('users.index')->with('success', 'User updated successfully.');
        } else {
            return redirect()->back()->withErrors('Password does not match the confirmation');
        }
    }

    public function destroy(User $user)
    {
        //$user = User::findOrFail($id);

        if ($user->delete()) {
            return redirect()->route('users.index')->with('success', 'User Deleted!');
        } else {
            return redirect()->back()->withErrors(['error', 'Account Deletion Failed!']);
        }
    }

    public function login()
    {
        return view('auth.login');
    }

    public function logout()
    {
        Auth::logout();
        return redirect('auth.login')->with('success', 'Successfully Logged Out!');
    }

    public function editAccount($id)
    {
        $user = User::findOrFail($id);
        return view('user.editAccount', compact('user'));
    }

    public function manageAccount($id)
    {
         $user = User::findOrFail($id);
        return view('user.account', compact('user'));
    }

    public function changePassword($id)
    {
        $user = User::findOrFail($id);

        return view('user.password', compact('user'));
    }

    public function changeAccountPassword($id)
    {
        $user = User::findOrFail($id);

        return view('user.accountPassword', compact('user'));
    }

    public function updatePassword($user_id, Requests\PasswordRequest $request)
    {
        $user = User::findOrFail($user_id);
        $old_password   = Input::get('old_password');
        if (Hash::check($old_password, Auth::user()->password)) {
            $user->password = bcrypt($request->password);
            $user->update();
            return redirect()->route('user.account', [$user->id])->with('success', true)->with('success', 'Password updated!');
        } else {
            return Redirect::back()->withErrors('Password incorrect');
        }
    }

    public function updateAccount($id, Requests\AccountRequest $request)
    {
        $user = User::findOrFail($id);
        
        $user->update($request->all());
        return redirect()->route('user.account', [$user->id])->with('success', 'User updated successfully!');
    }

    public function avatar() {
        return view('user.avatar');
    }


    /**
     * Upload user avatar for users
     * @param Request $request
     * 
     */
    public function uploadAvatar(Request $request) {
        $user = User::where('id', Auth::user()->id)->first();
        $user->setAvatar($request);
        $user->save();
    }

    /**
     * Upload an avatar for any user, for admin use
     * @param Request $request
     * @param $id
     */
    public function uploadAvatarAdmin (Request $request, $id) {
        $user = User::where('id', $id)->first();
        $user->setAvatar($request);
        $user->save();
    }
    
}
