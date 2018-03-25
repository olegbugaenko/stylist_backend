<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class VerifyJWTAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {

        //Trying to catch any exceptions for purpose of sending them into json as server response, with status 200 
        try {

            if (! $user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['error'=>'user_not_found'], 200);
            }
            else
            {
                //Saving user id in request params in order to be able to obtain it in Controller methods
                $request->merge(['user_id'=>$user->id]);
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

        return $next($request);
    }
}
