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

class UserAuth extends Controller
{
    
    public function login(Request $request)
    {
    	$auth_cred = $request->only('phonenumber','password');

    	try {
            
            if (! $token = JWTAuth::attempt($auth_cred)) {
                return response()->json(['error' => 'invalid_credentials','cred' => $auth_cred], 200);
            }
        } catch (\Exception $e) {
            
            return response()->json(['error' => 'could_not_create_token'], 500);
        } 

        return response()->json(compact('token'));
    }

    public function register(Request $request)
    {
    	$v = Validator::make($request->all(), [
	        'name' => 'required|max:255',
	        'second_name' => 'required',
	        'email' => 'required|email|unique:users|max:255',
	        'password' => 'required|confirmed|max:32',
	        'salon_name' => 'required|max:255',
	        'salon_address' => 'required',
	        'phonenumber' => 'required|unique:users|max:15',
	    ]);

	    if($v->fails())
	    {
	    	return response()->json(['errors' => $v->errors()->toArray()], 200);
	    }
	    else
	    {
	    	$user = new User;

	    	$user->fill([
	            'name' => $request->input('name'),
	            'last_name' => $request->input('second_name'),
	            'email' => $request->input('email'),
	            'password' => Hash::make($request->input('password')),
	            'phonenumber' => $request->input('phonenumber')
	        ])->save();

	        $salon = new \App\Salon;

	        $salon->fill([
	        	'salon_name'=>$request->input('salon_name'),
	        	'salon_address'=>$request->input('salon_name')
	        ]);

	        $user->salon()->save($salon);

	    	/*$info = User::create([
	            'name' => $request->input('name'),
	            'last_name' => $request->input('second_name'),
	            'email' => $request->input('email'),
	            'password' => Hash::make($request->input('password')),
	            'phonenumber' => $request->input('phonenumber')
	        ]);

	        $salon_data = new \App\Salon::create([
	        	'user_id'=>$info->id,
	        	'salon_name'=>$request->input('salon_name'),
	        	'salon_address'=>$request->input('salon_name')
	        ]);*/

	    	return response()->json(['success' => true, 'info' => $user, 'salon'=>$salon]);
	    }	
    }

    public function index(Request $request)
    {
    	$users_list = User::all()->toArray();

    	return response()->json($users_list);
    }

    public function is_logged(Request $request)
    {

		try {

			if (! $user = JWTAuth::parseToken()->authenticate()) {
				return response()->json(['error'=>'user_not_found'], 200);
			}
		} catch (Exception $e){
			return response()->json(['error'=>'invalid_token'], 200);
		
		} catch (TokenExpiredException $e) {

			return response()->json(['token_expired'], 200);

		} catch (TokenInvalidException $e) {

			return response()->json(['token_invalid'], 200);

		} catch (JWTException $e) {

			return response()->json(['token_absent'], 200);

		}

		return response()->json(compact('user'));

    }

}
