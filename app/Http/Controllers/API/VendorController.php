<?php

namespace App\Http\Controllers\API;

use App\Model\Vendor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class VendorController extends Controller
{
    public $successStatus = 200;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $vendors = Vendor::all();

        if($vendors){
            return response()->json(['responseCode'=>100,'responseMessage' => "Success", 'data'=> $vendors], $this-> successStatus);
        }
        else{
            return response()->json(['responseCode'=>100,'responseMessage' => "Failed", 'data'=> ''], 401);
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
        //
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
            return response()->json(['responseCode' => 200, 'responseMessage'=> "Success", 'data' => $vendor], 200 );
        }
        else{
            return response()->json(['responseCode' => 1001, 'responseMessage'=> "Failed", 'data' => $vendor], 200 );
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
        $vendor = Vendor::find($id);

        if($vendor){

            $updatedate = $request->all();
            $updatedate['updated_by'] = 1;

            // $this->validate($request, [
            //   'v_image_url' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            // ]);

            // if ($request->hasFile('v_image_url')) {
            //     $image = $request->file('v_image_url');
            //     $name = str_slug($request->title).'.'.$image->getClientOriginalExtension();
            //     $destinationPath = public_path('/uploads/articles');
            //     $imagePath = $destinationPath. "/".  $name;
            //     $image->move($destinationPath, $name);
            //     $updatedate['v_image_url'] = $name;
            // }

            $update = Vendor::where('id',$id)->update($updatedate);

            if($update){
                return response()->json(['responseCode' => 200, 'responseMessage'=> "Success", 'data' => $vendor], 200 );
            }
            else{
                return response()->json(['responseCode' => 1001, 'responseMessage'=> "Failed", 'data' => $vendor], 200 );
            }
            
        }
        else{
            return response()->json(['responseCode' => 1001, 'responseMessage'=> "Failed", 'data' => $vendor], 200 );
        }

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
