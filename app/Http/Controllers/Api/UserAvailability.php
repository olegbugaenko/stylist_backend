<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
//use JWTAuth;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class UserAvailability extends Controller
{

    public function setAvailability(Request $request)
    {
    	$v = Validator::make($request->all(), [
	        'from' => 'required|array|min:7',
	        'to' => 'required|array|min:7',
	        'is_free' => 'required|array|min:7'
	    ]);

	    if($v->fails())
	    {
	    	return response()->json(['errors' => $v->errors()->toArray()], 200);
	    }
	    else
	    {
	    	$ouser = new User;
	    	$user = $ouser->find($request->input('user_id'));

	    	$user->availabilities()->delete();

	        $availabilities = array();

	        for($i=0;$i<7;$i++)
	        {
	        	array_push($availabilities, new \App\UserAvailability([
	        		'day_id'=>$i,
	        		'from'=>$request->input('from.'.$i),
	        		'to'=>$request->input('to.'.$i),
	        		'is_free'=>$request->input('is_free.'.$i),
	        		
	        	]));	
	        }
	        

	        $user->availabilities()->saveMany($availabilities);

	    	return response()->json(['success' => true, 'info' => $availabilities,'user'=>$user]);
	    }	
    }

    public function getAvailability(Request $request)
    {
    	$ouser = new User;
    	$user = $ouser->find($request->input('user_id'));
    	$avails = $user->availabilities()->get();

    	return response()->json($avails);
    }

    
}
