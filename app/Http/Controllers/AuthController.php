<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController as BaseController;
use App\Models\User ;
use Illuminate\support\Facades\Auth;
use Illuminate\support\Facades\Hash;
use Validator ;
class AuthController extends BaseController
{
    public function register(Request $request){
        $validator=Validator::make($request->all(),[
            'name'=>'required',
            'email'=>'required|email',
            'password'=>'required',
            'c_password'=>'required|same:password'
        ]);
        if($validator->fails()){
            return $this->sendError('validate Error',$validator->errors());
        }
        $input = $request->all();
        $input['password']=Hash::make($input['password']);
        $user = User::create($input);
        $success['token']=$user->createToken('ameeragharaba')->accessToken;
        $success['name']=$user->name;
        return $this->sendResponse($success,'user Registered Successfully');
    }

    public function login(Request $request){

        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            $user=Auth::user();
            $success['token']=$user->createToken('ameeragharaba')->accessToken;
            $success['name']=$user->name;
            return $this->sendResponse($success,'user login Successfully');
        }
       else{
        return $this->sendError('Unauthorised',['error','unauthorised']);
       }



    }
}
