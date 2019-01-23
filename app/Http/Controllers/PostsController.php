<?php


namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;

class PostsController extends Controller
{
    public function __construct()
    {

    }

    public function getRelatedPosts()
    {
        return Post::orderBy('created_at', 'DESC')->get();
    }

    public function storePost(Request $request)
    {
        $postBody = $request->get('postBody');
        //$image = $request->get('image');
        $userId = $request->get('userId');
        $postInstance = new Post();
        $postInstance->post_body = $postBody;
        //$postInstance->image = $image;
        $postInstance->user_id = $userId;
        if ($postInstance->save()) {
            return response()->json(['code' => 200, 'message' => 'Post Saved Successfully', 'postData' => $postInstance]);
        }
        return response()->json(['message' => 'Post Not saved']);
    }

    public function editRelatedPost()
    {

    }

    public function updateRelatedPost()
    {

    }

    public function deleteRelatedPost($id)
    {
        $post = Post::find($id);

        if ($post->delete()) {
            return response()->json(['code' => 200, 'message' => 'Post deleted Successfully', 'id' => $id]);
        }
        return response()->json(['message' => 'Post Not deleted']);
    }
}