<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 
use App\Models\User;
use App\Models\UserProfile;
use Validator;


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

    public function showAllUsers()
    {   
        $user = Auth::user();
       
        $profileData = User::join('user_profiles', 'users.id', '=', 'user_profiles.user_id')
                                    // ->select("user.email", "userprofile.address")
                                    ->get();        
        return response()->json(['user'=> $profileData], $this->successStatus);
    }


    public function show(){

        $user = Auth::user();
       
        try {
            $profileData = User::where('user_id', "=", $user->id)->join('user_profiles', 'users.id', '=', 'user_profiles.user_id')
                                    // ->select("user.email", "userprofile.address")
                                    ->firstOrFail();
            return response()->json(['user'=> $profileData], $this->successStatus);

        } catch (\Throwable $th) {
            return "Error! Could not get the profile of the user";
        }
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
    public function update(Request $request)
    {
       
        $user = Auth::user();

        $profile = UserProfile::where('user_id','=', $user->id)->update([
            
            "permanent_address" => $request->input("permanent_address"),
            "profile_image" => $request->input("profile_image"),
            "state_of_origin" => $request->input("state_of_origin"),
            "phone_number" => $request->input("phone_number"),
        ]);

        if($profile){
            return response()
            ->json(["message" => " Profile data updated successfully.", 
                    "status" => "200",
                    "updated_profile" => $profile
                    ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    
    public function destroy()
    {   
        $user = Auth::user();

        $profileData = User::find($user->id)->userprofile;
        if(!$profileData->delete()){
            $message = "Unkown Error! Unable to delete this user data.";
            $status = 501;
        }else{
            $message = "User profile deleted successfully.";
            $status = 200;
        }
        return response()->json(["message"=> $message], $status);
    }
}
