<?php

namespace App\Http\Middleware;

use Closure;

use Auth;
use DB;
use App\Model\Vendor;

class VendorAuthenticator
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
        
        $is_admin = DB::table('vendors')
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
