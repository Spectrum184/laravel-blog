<?php

namespace App\Http\Controllers\User;

use App\Comment;
use App\CommentReply;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $comments = Comment::where('user_id', Auth::id())->latest()->get();

        return view('user.comments.index', compact('comments'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $comment = Comment::findOrFail($id);
        if ($comment->user_id == Auth::id()) {
            $comment->delete();
            CommentReply::where('comment_id', $id)->delete();

            Toastr::success('Deleted!', 'Success');
            return redirect()->back();
        } else {
            Toastr::error('You can not delete this comment!', 'Error');
            return redirect()->back();
        }
    }
}
