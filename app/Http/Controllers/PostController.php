<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Comment;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController as BaseController;
use Validator ;
use App\Http\Resources\Post as PostResource;
use Illuminate\support\Facades\Auth;
class PostController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
                $posts=Post::all();
                $comment=Comment::all();
                return $this->allPostAndComment($posts,$comment);

    }





    public function store(Request $request)
    {
        $input=$request->all();
       $validator = Validator::make($input,[
        'title'=>'required',
        'content'=>'required'
       ]);
       if($validator->fails()){
        return $this->sendError('validate Error',$validator->errors());
    }
    $user= Auth::user();
    $input['user_id']=$user->id;
    $post = Post::create($input);
    return $this->sendResponse($post,'posts send Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $post = Post::find($id);
        if(is_null($post)){
            return $this->sendError('post not found');
        }
        return $this->sendResponse($post,"post find successfully");
    }


    public function update(Request $request,$id)
    {
        $post = Post::find($id);
        $user= Auth::user();
        if($post->user_id ==$user->id){
            $input=$request->all();
            $validator = Validator::make($input,[
             'title'=>'required',
             'content'=>'required'
            ]);
            if($validator->fails()){
             return $this->sendError('validate Error',$validator->errors());
         }
         $post->title=$input['title'];
         $post->content=$input['content'];
         $post->save();
         return $this->sendResponse($post,'posts updated Successfully');
        }
        else {
            return $this->sendError('post can not updaet you must choose your post');
        }

    }


    public function destroy($id)
    {
        $post = Post::find($id);
        $comment = Post::find($id)->comments;
        $user= Auth::user();
        if($post->user_id ==$user->id){
            $post->delete();
            $comment->delete();
            return $this->sendResponse($post,'posts deleted Successfully');
        }
        else {
            return $this->sendError('post can not deleted you must choose your post');
        }
    }
}
