<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 
use App\Models\User;
use App\Models\UserProfile;

class userProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $validator = Validator::make($request->all(), [ 
            'phone_number' => 'required', 
            'permanent_address' => 'required',
            
        ]);
        if ($validator->fails()) { 
            return response()->json(['error'=>$validator->errors()], 401);            
        }

        $profile = new UserProfile;
        $user = new User;
        $user = Auth::user();

        $profile->phone_number = $request->phone_number;
        $profile->permanent_address = $request->permanent_address;
        $profile->profile_image = $request->profile_image;
        $profile->state_of_origin = $request->state_of_origin;
        $profile->user_id = $user->id;
        if($profile->save()){
            return "Data saved to database succefully.";
        }else{
            return "Unknown error. Your data couldn\'t be saved to our database.";
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public $successStatus = 200; 

    public function show()
    {   
        $user = Auth::user();
       
        $profileData = User::join('user_profiles', 'users.id', '=', 'user_profiles.user_id')
                                    // ->select("user.email", "userprofile.address")
                                    ->get();        
        return response()->json(['user'=> $profileData], $this->successStatus);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {   

    }
}
