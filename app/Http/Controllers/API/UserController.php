<?php


namespace App\Http\Controllers\API;
use Illuminate\Http\Request; 
use App\Http\Controllers\Controller; 
use App\User; 
use App\Model\Login;
use App\Model\Vendor;
use Illuminate\Support\Facades\Auth; 
use Validator;

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
	            return response()->json(['success' => $success], $this-> successStatus); 
	        }
    	}
        else if(request('v_phone')){
        	if(Auth::attempt(['v_phone' => request('v_phone'), 'password' => request('password')])){ 
	            $user = Auth::user(); 

	            $success['token'] =  $user->createToken('MyApp')-> accessToken; 
	            return response()->json(['success' => $success], $this-> successStatus); 
	        } 
	        
        }
        else{ 
	        return response()->json(['error'=>'Unauthorised'], 401); 
	    } 
        
    }
	/** 
     * Register api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function register(Request $request) 
    { 
        

        if($request->input('v_email')){
	        $validator = Validator::make($request->all(), [ 
	            'v_first_name' => 'required', 
	            'v_last_name' => 'required', 
	            'v_email' => 'required|email',
	            // 'v_phone' => 'required', 
	            'password' => 'required', 
	            'c_password' => 'required|same:password', 
	        ]);

	        $input = $request->all(); 
	        unset($input->v_phone);


        }
        else if($request->input('v_phone')){
        	$validator = Validator::make($request->all(), [ 
	            'v_first_name' => 'required', 
	            'v_last_name' => 'required', 
	            // 'v_email' => 'required|email',
	            'v_phone' => 'required', 
	            'password' => 'required', 
	            'c_password' => 'required|same:password', 
	        ]);

	        $input = $request->all(); 
	        unset($input->v_email);
        }



		if ($validator->fails()) { 
            return response()->json(['error'=>$validator->errors()], 401);            
        }
		

        $input['password'] = bcrypt($input['password']); 

        $user = Login::create($input); 

        if($request->input('user_type') == 'Vendor'){
        	$users  = new Vendor();
	        $users['login_id'] = $user->id;
	        $users['v_first_name'] = $input['v_first_name'];
	        $users['v_last_name'] = $input['v_last_name'];
	        if(isset($input['v_email'])){
	        	$users['v_email'] = $input['v_email'];
	        }
	        else{
	        	$users['v_phone'] = $input['v_phone'];
	        }
	        
	        
	        $users->save();
        }
        else if($request->input('user_type') == 'User'){
        	$users  = new User();
	        $users['login_id'] = $user->id;
	        $users['v_first_name'] = $input['v_first_name'];
	        $users['v_last_name'] = $input['v_last_name'];
	        if(isset($input['v_email'])){
	        	$users['v_email'] = $input['v_email'];
	        }
	        else{
	        	$users['v_phone'] = $input['v_phone'];
	        }
	        $users->save();
        }
        else if($request->input('user_type') == 'Admin'){
        	$users  = new User();
	        $users['login_id'] = $user->id;
	        $users['v_first_name'] = $input['v_first_name'];
	        $users['v_last_name'] = $input['v_last_name'];
	        if(isset($input['v_email'])){
	        	$users['v_email'] = $input['v_email'];
	        }
	        else{
	        	$users['v_phone'] = $input['v_phone'];
	        }
	        $users->save();
        }

        // $success['token'] =  $user->createToken('MyApp')-> accessToken; 
        // $success['v_first_name'] =  $user->v_email;
		//return response()->json(['success'=>$success], $this-> successStatus); 
		return response()->json(['success'=> "You are succesfully register"],$this-> successStatus); 
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

        return response()->json(['success' => $user], $this-> successStatus); 
    } 
}
