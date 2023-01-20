<?php

namespace App\Http\Controllers;
use App\Models\Post;

use App\Models\Comment;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController as BaseController;
use Validator ;
use Illuminate\support\Facades\Auth;
class CommentController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request , $post_id)
    {

        $input=$request->all();
        $validator = Validator::make($input,[
            'comment'=>'required'
           ]);
        if($validator->fails()){
            return $this->sendError('validate Error',$validator->errors());
        }

        $user= Auth::user();
        $input['post_id']=$post_id;
        $input['user_id']=$user->id;
        $comment =Comment::create($input);
        return $this->sendResponse($comment,'comment add Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function show($post_id)
    {
        $comments = Post::findOrFail($post_id)->comments  ;
        if(is_null($comments)){
            return $this->sendError('no comments yet');
        }
        return $this->sendResponse($comments,"comment find successfuly");
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $comment = Comment::find($id);
        $user= Auth::user();
        if($comment->user_id == $user->id){
            $input=$request->all();
            $validator = Validator::make($input,[
             'comment'=>'required'
            ]);
            if($validator->fails()){
             return $this->sendError('validate Error',$validator->errors());
         }

         $comment->comment=$input['comment'];
         $comment->save();
         return $this->sendResponse($comment,'comments updated Successfully');
        }
        else {
            return $this->sendError('can no update comments please choose your comment');
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $comment = Comment::find($id);
        $user= Auth::user();
        if($comment->user_id == $user->id){
            $comment->delete();
            return $this->sendResponse($comment,'comment deleted Successfully');
        }
        else {
            return $this->sendError('comment can not deleted you must choose your comment');

        }

    }
}
