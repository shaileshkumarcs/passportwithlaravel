<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request; 
use App\Http\Controllers\Controller; 
use App\User; 
use App\Model\Login;
use App\Model\Vendor;
use App\Model\Admin;
use Illuminate\Support\Facades\Auth; 
use Validator;
use DB;

class UserController extends Controller
{
    public $successStatus = 200;
	/** 
     * login api 
     * 
     * @return \Illuminate\Http\Response 
     */ 

    public function login(){ 
        
    	if(request('v_email')){
    		if(Auth::attempt(['v_email' => request('v_email'), 'password' => request('password')])){ 
	            $user = Auth::user(); 

	            $success['token'] =  $user->createToken('MyApp')-> accessToken; 

                return response()->json(['responseCode'=>100,'responseMessage' => "Success", 'Token'=> $success], $this-> successStatus);
	           // return response()->json(['success' => $success], $this-> successStatus); 
	        }
    	}
        else if(request('v_phone')){
        	if(Auth::attempt(['v_phone' => request('v_phone'), 'password' => request('password')])){ 
	            $user = Auth::user(); 

	            $success['token'] =  $user->createToken('MyApp')-> accessToken; 
	            
	            //return response()->json(['success' => $success], $this-> successStatus); 

                return response()->json(['responseCode'=>100,'responseMessage' => "Success", 'Token'=> $success], $this-> successStatus);
	        } 
	        
        }
        else{ 
	        //return response()->json(['error'=>'Unauthorised'], 401); 

            return response()->json(['responseCode'=>100,'responseMessage' => "Unauthorised", 'Token'=> ''], 401);
	    } 
        
    }
	/** 
     * Register api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function register(Request $request) 
    { 
    	//Check if Email is available then only get inside
        if($request->input('v_email')){
        	$rules = [
        		'v_first_name' => 'required', 
	            'v_last_name' => 'required', 
	            'v_email' => 'required|email|unique:logins',
	            // 'v_phone' => 'required', 
	            'password' => 'required', 
	            'c_password' => 'required|same:password',
        	];

	        $validator = Validator::make($request->all(), $rules);
	        $input = $request->all(); 
	        unset($input->v_phone);
        }
        //Check if Phone is available then only get inside
        else if($request->input('v_phone')){
        	$validator = Validator::make($request->all(), [ 
	            'v_first_name' => 'required', 
	            'v_last_name' => 'required', 
	            // 'v_email' => 'required|email',
	            'v_phone' => 'required|unique:logins', 
	            'password' => 'required', 
	            'c_password' => 'required|same:password', 
	        ]);

	        $input = $request->all(); 
	        unset($input->v_email);
        }
        else{
        	
        	return response()->json(['responseCode'=>100,'responseMessage' => "Please enter data", 'data'=> ''], 401);
        }

        /**
		Check if input values not available
		Return the valid message
        **/
		if ($validator->fails()) { 
			$error_data = json_decode($validator->messages());
			foreach($error_data as $error){
				$msg = $error[0];
			}
			return response()->json(['error'=>$msg], 401);            
        }

        $input['password'] = bcrypt($input['password']); 

        

        if($request->input('user_type') == 'Vendor'){

        	$user = Login::create($input); 

        	$users  = new Vendor();
	        $users['login_id'] = $user->id;
	        $users['v_first_name'] = $input['v_first_name'];
	        $users['v_last_name'] = $input['v_last_name'];
            $users['created_by'] = $user->id;
	        if(isset($input['v_email'])){
	        	$users['v_email'] = $input['v_email'];
	        }
	        else{
	        	$users['v_phone'] = $input['v_phone'];
	        }
	        
	        
	        $users->save();

	        return response()->json(['responseCode' => 200, 'responseMessage'=> "You are succesfully register", 'data' => ''],$this-> successStatus);
        }
        else if($request->input('user_type') == 'User'){

        	$user = Login::create($input); 

        	$users  = new User();
	        $users['login_id'] = $user->id;
	        $users['v_first_name'] = $input['v_first_name'];
	        $users['v_last_name'] = $input['v_last_name'];
            $users['created_by'] = $user->id;
	        if(isset($input['v_email'])){
	        	$users['v_email'] = $input['v_email'];
	        }
	        else{
	        	$users['v_phone'] = $input['v_phone'];
	        }
	        $users->save();

	        return response()->json(['responseCode' => 200, 'responseMessage'=> "You are succesfully register", 'data' => ''],$this-> successStatus);
        }
        else if($request->input('user_type') == 'Admin'){

        	$user = Login::create($input); 

        	$users  = new Admin();
	        $users['login_id'] = $user->id;
	        $users['v_first_name'] = $input['v_first_name'];
	        $users['v_last_name'] = $input['v_last_name'];
            $users['created_by'] = $user->id;
	        if(isset($input['v_email'])){
	        	$users['v_email'] = $input['v_email'];
	        }
	        else{
	        	$users['v_phone'] = $input['v_phone'];
	        }
	        $users->save();

	        return response()->json(['responseCode' => 200, 'responseMessage'=> "You are succesfully register", 'data' => ''],$this-> successStatus);
        }

        else{
        	return response()->json(['responseCode' => 200, 'responseMessage'=> "Please provide user type", 'data' => ''],402);

        }
        // $success['token'] =  $user->createToken('MyApp')-> accessToken; 
        // $success['v_first_name'] =  $user->v_email;
		//return response()->json(['success'=>$success], $this-> successStatus); 
		 
    }
	/** 
     * details api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function details() 
    { 
        $user = Auth::user(); 

        $user_details = User::find($user->id);

        $user->details = $user_details;

        //return response()->json(['success' => $user], $this-> successStatus);

        return response()->json(['responseCode' => 200, 'responseMessage'=> "Success", 'data' => $user],$this-> successStatus);


    } 

    public function users(){

#    	$allusers = Login::all();

    	$allusers = [];
    	$users = DB::table('logins')
    					->select('*')
						->join('users', 'logins.id', '=','users.id')
    					->get();

    	foreach($users as $user){
    		$allusers[] = $user;
    	}

    	// $vendors = DB::table('logins')
    	// 				->select('*')
					// 	->join('vendors', 'logins.id', '=','vendors.id')
    	// 				->get();

    	// foreach($vendors as $vendor){
    	// 	$allusers[] = $vendor;
    	// }

    	// $admins = DB::table('logins')
    	// 				->select('*')
					// 	->join('admins', 'logins.id', '=','admins.id')
    	// 				->get();

    	// foreach($admins as $admin){
    	// 	$allusers[] = $admin;
    	// }

    	//print_r(json_encode($allusers));
    	//return response()->json(['success' => $allusers], $this-> successStatus); 	

        return response()->json(['responseCode' => 200, 'responseMessage'=> "Success", 'data' =>  $allusers],$this-> successStatus);
    }
}
