<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Comment;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller {
    
    public function create(Request $request) {
        $post=new Post;
        $post->user_id = Auth::user()->id;
        $post->desc = $request->desc;

        if($request->photo != '') {
            $photo = time().'.jpg';
            file_put_contents('storage/posts/'.$photo,base64_decode($request->photo));
            $post->photo =$photo;
        }

        $post->save();
        $post->user;

        return response()->json([
            'success' => true,
            'message' => 'posted',
            'post' => $post
        ]);
    }

    public function update(Request $request) {
        $post = Post::find($request->id);
        if(Auth::user()->id != $post->user_id) {
            return response()->json([
                'success' => false,
                'message' => 'user is not authorized'
            ]);
        } else {
            $post->desc = $request->desc;
            $post->update();
            return response()->json([
                'success' => true,
                'message' => 'updated successully',
            ]);
        }
    }

    public function delete(Request $request) {
        $post = Post::find($request->id);

        if(Auth::user()->id != $post->user_id) {
            return response()->json([
                'success' => false,
                'message' => 'unautorized action'
            ]);
        } else {
            if($post->photo != '') {
                Storage::delete('public/posts/'.$post->photo);
            }
            $post->delete();
            return response()->json([
                'success' => true,
                'message' => 'post is deleted'
            ]);
        }
    }

    public function posts() {
        $posts = Post::orderBy('id', 'DESC')->get();
        foreach($posts as $post) {
            //user of post
            $post->user;

            //count comments
            $post['CountComments'] = count($post->comments);

            //count likes
            $post['CountLikes']= count($post->likes);

            //check self like
            $post['SelfLike'] = false;
            foreach($post->likes as $like) {
                if($like->user_id == Auth::user()->id) {
                    $post['SelfLike'] = true;
                }
            }
        }
        return response()->json([
            'success' => true,
            'posts' => $posts
        ]);
    }

    public function myPosts(Request $request) {
        $posts = Post::where('user_id', Auth::user()->id)->orderBy('id','desc')->get();
        $user = Auth::user();
        return response()->json([
            'success' => true,
            'posts' => $posts,
            'user' => $user
        ]);
    }
}
