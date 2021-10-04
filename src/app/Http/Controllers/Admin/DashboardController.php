<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Comment;
use App\Http\Controllers\Controller;
use App\Http\Requests\PasswordRequest;
use App\Http\Requests\UserRequest;
use App\Post;
use App\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DashboardController extends Controller
{

    /**
     * Redirect view admin.
     *
     * @var void
     */
    public function index()
    {
        $posts = Post::all();
        $comments = Comment::latest()->get();
        $users = User::all();
        $categories = Category::all();

        return view('admin.index', compact('posts', 'comments', 'users', 'categories'));
    }

    /**
     * Show profile.
     *
     * @var void
     */
    public function showProfile()
    {
        $user = User::find(Auth::user()->id);
        return view('admin.profile', compact('user'));
    }

    /**
     * update profile.
     *
     *  @param  UserRequest
     */
    public function updateProfile(UserRequest $request)
    {
        $image = $request->image;

        $user = User::findOrFail(Auth::user()->id);

        if ($request->image != null) {
            $imageName = Str::slug($request->name, '-') . uniqid() . '.' . $image->getClientOriginalName();

            if (!Storage::disk('public')->exists('user')) {
                Storage::disk('public')->makeDirectory('user');
            }

            //delete file if exist
            if ($user->image != 'avatar.jpg' && Storage::disk('public')->exists('user/' . $user->image)) {
                Storage::disk('public')->delete('user/' . $user->image);
            }

            $image->storeAs('user', $imageName, 'public');
        } else {
            $imageName = $user->image;
        }

        $user->name = $request->name;
        $user->username = $request->username;
        $user->image = $imageName;
        $user->about = $request->about;

        $user->save();

        Toastr::success('Updated profile!', 'Success');

        return redirect()->back();
    }

    /**
     * update profile.
     *
     * @param  PasswordRequest  $request
     */
    public function changePassword(PasswordRequest $request)
    {
        $old_pass = Auth::user()->password;
        if (Hash::check($request->old_password, $old_pass)) {
            if (!Hash::check($request->password, $old_pass)) {
                $user = User::find(Auth::user()->id);
                $user->password = Hash::make($request->password);
                $user->save();

                Auth::logout();
                return redirect()->back();
            } else {
                Toastr::error('New password and old password are the same!', 'Error');

                return redirect()->back();
            }
        } else {
            Toastr::error('Enter correct old password!', 'Error');

            return redirect()->back();
        }
    }
}
