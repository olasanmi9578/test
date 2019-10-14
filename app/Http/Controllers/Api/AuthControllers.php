<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades\Hash;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;

use Validator;
use App\User; 

class AuthControllers extends Controller
{
    //construct

    public function __construct (){
    	$this->successStatus = 200;
    	$this->errorStatus = 401;
    	$this->user = new User();
    	$this->loginUser = "";
    } 

    //register function
    public function registers (RegisterRequest $request){
    	$this->user->name = $request->username;
		$this->user->email = $request->email;
		$this->user->password = Hash::make($request->password);
		$this->user->save();
		return response()->json(['success' => 'Usuario registrado correctamente'], $this->successStatus);
    }

    //logins function 
    public function logins (LoginRequest $request){
	    //valdiate users credentials
	    if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){
	    	//set access tokens and return this data.
		    $this->loginUser = Auth::user(); 
		    $success['token'] =  $this->loginUser->createToken('AppName')-> accessToken;
		    	return response()->json(['success' => $success], $this->successStatus); 
	    } else {
	    	//if no in bbdd credentials 
	   		return response()->json(['error'=>'Unauthorised'], 401); 
	    } 
    }

    //get auth user data
    public function getUser (){
		$user = Auth::user();
	 	return response()->json(['success' => $user], $this->successStatus); 
	}

	//logout function
	public function logouts (){
		$user = Auth::user()->token();
		$user->revoke();
		return response()->json(['success' => 'Se ha cerrado sesión'], $this->successStatus);
	}

}
