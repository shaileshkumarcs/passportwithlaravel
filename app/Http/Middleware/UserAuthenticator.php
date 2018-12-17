<?php

namespace App\Http\Middleware;

use Closure;
use DB;
use Auth;
use User;


class UserAuthenticator
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        $user = Auth::user();
        
        $is_admin = DB::table('users')
                    ->where('login_id', $user->id)
                    ->count();
                    
        if($is_admin){
           
            return $next($request);
        }
        else{
           
            return response()->json(['responseCode' => 1001, 'responseMessage'=> "You are not authorized", 'data' => ''], 401 );
        }
    }
}
