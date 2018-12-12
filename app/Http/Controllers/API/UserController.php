<?php


namespace App\Http\Controllers\API;
use Illuminate\Http\Request; 
use App\Http\Controllers\Controller; 
use App\User; 
use App\Model\Login;
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
        if(Auth::attempt(['v_email' => request('v_email'), 'password' => request('password')])){ 
            $user = Auth::user(); 

            $success['token'] =  $user->createToken('MyApp')-> accessToken; 
            return response()->json(['success' => $success], $this-> successStatus); 
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
        $validator = Validator::make($request->all(), [ 
            'v_first_name' => 'required', 
            'v_last_name' => 'required', 
            'v_email' => 'required|email', 
            'password' => 'required', 
            'c_password' => 'required|same:password', 
        ]);
		if ($validator->fails()) { 
            return response()->json(['error'=>$validator->errors()], 401);            
        }
		$input = $request->all(); 
        $input['password'] = bcrypt($input['password']); 

        //print_r($input);

        $user = Login::create($input); 


        $users  = new User();
        $users['login_id'] = $user->id;
        $users['v_first_name'] = $input['v_first_name'];
        $users['v_last_name'] = $input['v_last_name'];
        $users['v_email'] = $input['v_email'];
        $users['v_phone'] = $input['v_phone'];
        $users->save();





        $success['token'] =  $user->createToken('MyApp')-> accessToken; 
        $success['v_first_name'] =  $user->v_email;
		return response()->json(['success'=>$success], $this-> successStatus); 
    }
	/** 
     * details api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function details() 
    { 
        $user = Auth::user(); 

        print_r(json_encode($user));


        //return response()->json(['success' => $user], $this-> successStatus); 
    } 
}
