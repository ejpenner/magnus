<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;

use App\Http\Requests;
use App\User;
use App\Profile;
use App\Permission;
use App\Role;
use App\Gallery;
use App\Watch;

class UserController extends Controller
{
    public function index()
    {
        $users = User::paginate(10);
        
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
        $roles = Role::lists('role_name', 'id');
        
        return view('user.create', compact('roles'));
    }

    public function store(Requests\UserCreateRequest $request)
    {
        $user = new User;

        $user->username = $request->username;
        $user->name = $request->name;
        $user->profile_slug = str_slug($request->username, '-');
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->roles()->attach($request->input('role_id'));
        $user->save();
        $user->galleries()->save(new Gallery(['main_gallery'=>1, 'name'=>'Main Gallery']));
        Profile::create(['user_id'=>$user->id]);
        
        return redirect()->route('users.index')->with('success', 'Your user was created.');
    }

    public function edit(User $user)
    {
        $roles = Role::lists('role_name', 'id');
        return view('user.edit', compact('user', 'roles'));
    }

    public function update(User $user, Requests\UserEditRequest $request)
    {
        if ($request->password == $request->password_confirmation) {
            $user->name = $request->name;
            $user->username = $request->username;
            $user->email = $request->email;
            $user->slug = str_slug($request->username, '-');
            $user->timezone = $request->input('timezone');
            if ($request->password != "" and $request->password != null) {
                $user->password = bcrypt($request->password);
            }
            $user->roles()->detach();

            $user->roles()->attach($request->input('role_id'));

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

    /**
     * Update password route
     * @param $user_id
     * @param Requests\PasswordRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
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

    /**
     * Non-power user account update route
     * @param $id
     * @param Requests\AccountRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateAccount($id, Requests\AccountRequest $request)
    {
        $user = User::findOrFail($id);
        
        $user->update($request->all());
        return redirect()->route('user.account', [$user->id])->with('success', 'User updated successfully!');
    }

    /**
     * Returns the change avatar view
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function avatar() {
        return view('user.avatar');
    }

    /**
     * Route for power users to change other user's avatars
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function avatarAdmin($id) {
        $user = User::findOrFail($id);
        return view('user.avatarAdmin', compact('user'));
    }
    
    /**
     * Upload user avatar for users
     * @param Request $request
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

    /**
     *  Add the selected user to the Auth'd user's watch list
     * @param Request $request
     * @param User $user
     * @return $this|\Illuminate\Http\RedirectResponse\
     */
    public function watchUser(Request $request, User $user) {
        foreach(Auth::user()->watchedUsers as $watched) {
            if($user->id == $watched->user_id) {
                return redirect()->to(app('url')->previous())->withErrors('You are already watching this user!');
            }
        }
        if(Auth::user()-> id != $user->id) {
            Watch::watchUser(Auth::user(), $user, $request);
            return redirect()->to(app('url')->previous())->with('success', 'You have added ' . $user->name . ' to your watch list!');
        } else {
            return redirect()->to(app('url')->previous())->withErrors('You can\'t watch yourself!');
        }
    }

    /**
     * 
     * @param Request $request
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function unwatchUser(Request $request, User $user)
    {
        Watch::unwatchUser(Auth::user(), $user);
        return redirect()->to(app('url')->previous())->with('success', 'You have unwatched '.$user->name.'.');
    }
}
