<?php

namespace App\Http\Controllers\API;

use Auth;
use App\User;
use App\Model\Login;
use App\Model\Vendor;
use App\Model\Admin;
use Validator;
use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    public $successStatus = 200;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $allusers = User::all();

        if($allusers){

            return response()->json(['responseCode' => 200, 'responseMessage'=> "Success", 'data' => $allusers],$this-> successStatus);

        }
        else{

            return response()->json(['responseCode'=>100,'responseMessage' => "Data not found", 'data'=> ''], 401);
        }

    }

    public function vendors(){

        $allvendors = Vendor::all();

        if($allvendors){

            return response()->json(['responseCode' => 200, 'responseMessage'=> "Success", 'data' => $allvendors],$this-> successStatus);

        }
        else{

            return response()->json(['responseCode'=>100,'responseMessage' => "Data not found", 'data'=> ''], 401);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
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

        $user_login = Auth::user();

        if($request->input('user_type') == 'Vendor'){

            $user = Login::create($input); 

            $users  = new Vendor();
            $users['login_id'] = $user->id;
            $users['v_first_name'] = $input['v_first_name'];
            $users['v_last_name'] = $input['v_last_name'];
            $users['created_by'] = $user_login->id;
            if(isset($input['v_email'])){
                $users['v_email'] = $input['v_email'];
            }
            else{
                $users['v_phone'] = $input['v_phone'];
            }
            
            
            $users->save();

            return response()->json(['responseCode' => 200, 'responseMessage'=> "Vendor created succesfully", 'data' => ''],$this-> successStatus);
        }
        else if($request->input('user_type') == 'User'){

            $user = Login::create($input); 

            $users  = new User();
            $users['login_id'] = $user->id;
            $users['v_first_name'] = $input['v_first_name'];
            $users['v_last_name'] = $input['v_last_name'];
            $users['created_by'] = $user_login->id;
            if(isset($input['v_email'])){
                $users['v_email'] = $input['v_email'];
            }
            else{
                $users['v_phone'] = $input['v_phone'];
            }
            $users->save();

            return response()->json(['responseCode' => 200, 'responseMessage'=> "User created succesfully", 'data' => ''],$this-> successStatus);
        }
        else if($request->input('user_type') == 'Admin'){

            $user = Login::create($input); 

            $users  = new Admin();
            $users['login_id'] = $user->id;
            $users['v_first_name'] = $input['v_first_name'];
            $users['v_last_name'] = $input['v_last_name'];
            $users['created_by'] = $user_login->id;
            if(isset($input['v_email'])){
                $users['v_email'] = $input['v_email'];
            }
            else{
                $users['v_phone'] = $input['v_phone'];
            }
            $users->save();

            return response()->json(['responseCode' => 200, 'responseMessage'=> "Admin created succesfully", 'data' => ''],$this-> successStatus);
        }

        else{
            return response()->json(['responseCode' => 200, 'responseMessage'=> "Please provide user type", 'data' => ''],402);

        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $vendor = Vendor::find($id);

        if($vendor){
            return response()->json(['responseCode' => 200, 'responseMessage'=> "Success", 'data' => $vendor],$this-> successStatus);
        }
        else{
            return response()->json(['responseCode' => 200, 'responseMessage'=> "Vendor does not exist", 'data' => ''],402);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
