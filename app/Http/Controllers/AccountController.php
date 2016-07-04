<?php

namespace Magnus\Http\Controllers;

use Illuminate\Http\Request;

use Magnus\Http\Requests;
use Magnus\User;
use Magnus\Preference;

class AccountController extends Controller
{
    /**
     * Return the edit account view
     * @param User $user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function manageAccount(User $user)
    {
        return view('user.account.account', compact('user'));
    }

    /**
     * Update $user's preferences
     * @param Request $request
     * @param User $user
     */
    public function updatePreferences(Request $request, User $user)
    {
        $newPreferences = [
            'sex' => $request->input('sex'),
            'date_of_birth' => Preference::makeDOB($request->input('dob_day'), $request->input('dob_month'), $request->input('dob_year'))->toDateString(),
            'dob_day' => $request->input('dob_day'),
            'dob_month' => $request->input('dob_month'),
            'dob_year' => $request->input('dob_year'),
            'show_dob' => $request->input('show_dob'),
            'per_page' => $request->input('per_page')
        ];
        $user->preferences()->update($newPreferences);
        return redirect()->route('account.manage', [$user->slug])->with('success', 'Site preferences updated successfully!');
    }

    /**
     * Non-power user account update route
     * @param $id
     * @param Requests\AccountRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateAccount(Requests\AccountRequest $request, User $user)
    {
        $user->update($request->all());
        return redirect()->route('account.manage', [$user->slug])->with('success', 'User updated successfully!');
    }
    
    /**
     * Update password route
     * @param $user_id
     * @param Requests\PasswordRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updatePassword(Requests\PasswordRequest $request, User $user)
    {
        $old_password = Input::get('old_password');
        if (Hash::check($old_password, Auth::user()->password)) {
            $user->password = bcrypt($request->password);
            $user->update();
            return redirect()->route('account.manage', [$user->slug])->with('success', true)->with('success', 'Password updated!');
        } else {
            return redirect()->back()->withErrors('Password incorrect');
        }
    }

    /**
     * Upload user avatar for users
     * @param Request $request
     */
    public function uploadAvatar(Request $request, User $user) {
        //$user = User::where('id', Auth::user()->id)->first();
        $user->setAvatar($request);
        $user->save();
    }

    /**
     * Upload an avatar for any user, for admin use
     * @param Request $request
     * @param $id
     */
    public function uploadAvatarAdmin (Request $request, User $user) {
        //$user = User::where('id', $id)->first();
        $user->setAvatar($request);
        $user->save();
    }
}
