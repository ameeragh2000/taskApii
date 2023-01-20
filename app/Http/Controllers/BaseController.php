<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BaseController extends Controller
{
    public function sendResponse($result , $message){
        $response = [
            'success' => true ,
            'data'=> $result ,
            'message' => $message
        ];

        return  response()->json($response, 200);
    }

    public function allPostAndComment($post , $comment){
        $response = [
            'success' => true ,
            'post'=> $post ,
            'comment' => $comment
        ];

        return  response()->json($response, 200);
    }



    public function sendError($error , $errormessage =[]){
        $response = [
            'success' => false ,
            'message' => $error
        ];
        if(!empty($errormessage)){
            $response['data']=$errormessage ;
        }

        return  response()->json($response, 404);
    }
}