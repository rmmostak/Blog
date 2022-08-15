<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Comment;
use App\Models\User;

class CommentController extends Controller {
    
    public function create(Request $request) {
        $comment=new Comment;

        $comment->user_id = Auth::user()->id;
        $comment->post_id = $request->id;
        $comment->comment = $request->comment;

        $comment->save();

        return response()->json([
            'success' => true,
            'message' => 'commented',
            'comment' => $comment
        ]);
    }

    public function update(Request $request) {
        $comment = Comment::find($request->id);
        if($comment->id != Auth::user()->id) {
            return response()->json([
                'success' => false,
                'message' => 'unauthorized access'
            ]);
        } else {
            $comment->comment = $request->comment;
            $comment->update();

            return response()->json([
                'success' => true,
                'message' => 'comment updated'
            ]);
        }
    }

    public function delete(Request $request) {
        $comment=Comment::find($request->id);

        if($comment->id != Auth::user()->id) {
            return response()->json([
                'success' => false,
                'message' => 'unauthorized access'
            ]);
        } else {
            $comment->delete();
            return response()->json([
                'success' => true,
                'message' => 'comment deleted'
            ]);
        }
    }

    public function comments(Request $request) {
        $comments=Comment::where('post_id', $request->id)->get();

        foreach($comments as $comment) {
            $comment->user;
        }

        return response()->json([
            'success' => true,
            'comments' => $comments
        ]);
    }
}
