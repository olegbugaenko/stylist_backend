<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\User;
use App\Service;
use Illuminate\Support\Facades\Validator;

class Services extends Controller
{
    //

	public function getServices($user_id)
	{
		$user = new User;

		$services = $user->find($user_id)->load('services');

		return response()->json($services);
	}

	public function myServices(Request $request)
	{
		$user_id = $request->input('user_id',0);

		if($user_id)
		{
			$user = new User;

			$services = $user->find($user_id)->load('services');

			return response()->json($services);
		}
		else
		{
			return response()->json(['error'=>'jwtauth_token_error']);
		}
	}

	public function saveService(Request $request)
	{
		$v = Validator::make($request->all(), [
	        'service_id' => 'required',
	        'user_id' => 'required',
	        'duration' => 'required',
	     	'price'	=> 'required'
	    ]);

	    if($v->fails())
	    {
	    	return response()->json(['errors' => $v->errors()->toArray()], 200);
	    }
	    else
	    {
	    	$user = new User;

	    	$current_user = $user->find($request->input('user_id'));

	    	$modifying_service = $current_user->services()->find($request->input('service_id'));
	    	
	    	if($modifying_service)
	    	{
	    		$current_user->services()->updateExistingPivot($request->input('service_id'),['duration'=>$request->input('duration'),'price'=>$request->input('price')]);
	    	
	    		return response()->json(['status'=>'ok','action'=>'updated']);
	    	}
	    	else
	    	{
	    		$service = new Service;

	    		$selected_service = $service->find($request->input('service_id'));

	    		if($selected_service->first())
	    		{
	    			$current_user->services()->attach([$selected_service->id=>['duration'=>$request->input('duration'),'price'=>$request->input('price')]]);
	    		
	    			return response()->json(['status'=>'ok','action'=>'added','object'=>$selected_service]);
	    		}
	    		else
	    		{
	    			return response()->json(['status'=>'err','action'=>'invalid_service']);
	    		}
	    	}

	    }
	}

	public function availableServices(Request $request)
	{
		$user = new User;

	    $current_user = $user->find($request->input('user_id'));

	    $service = new Service;

	    $user_services = $current_user->services()->get();

	    $available_services = $service->all()->filter(function($value, $key) use ($user_services){
	    	return !($user_services->contains($value->id));
	    });

	    return response()->json($available_services);
	}

}
