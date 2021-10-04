<?php

namespace App\Http\Controllers\Admin;

use App\Comment;
use App\CommentReply;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $comments = Comment::all();

        return view('admin.comments.index', compact('comments'));
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
        // CommentReply::where('comment_id', $id)->delete();
        $comment->delete();

        Toastr::success('Deleted!', 'Success');
        return redirect()->back();
    }
}
