<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use App\Models\User;
use App\Models\VendorDetail;
use DB;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\PasswordReset;
//use Illuminate\Support\Str;

class ForgotPasswordController extends Controller
{
    private $apiToken;
      public function __construct()
      {
        // Unique Token
        $this->apiToken = uniqid(base64_encode(rand(10000,99999)));
      }
    
	public function forgot( Request $request )
	{
        $input = $request->only('email');
        $validator = Validator::make($input, [
        'email' => "required|email"
        ]);
        if ($validator->fails()) {
        return response(['errors'=>$validator->errors()->all()], 422);
        }
        $response =  Password::sendResetLink($input);
        if($response == Password::RESET_LINK_SENT){
        $message = "Mail send successfully";
        }else{
        $message = "Email could not be sent to this email address";
        }
        //$message = $response == Password::RESET_LINK_SENT ? 'Mail send successfully' : GLOBAL_SOMETHING_WANTS_TO_WRONG;
        $response = ['data'=>'','message' => $message];
        return response($response, 200);
        }
        
        protected function sendReset(Request $request)
        {
            $data=['email'=>$request->input('email'),'token'=>$request->input('token')];
            return view('admin.resetpassword',compact('data'));
        }
        
        protected function sendResetResponse(Request $request)
        {
            $input = $request->only('email', 'password', 'password_confirmation');
            $validated =$request->validate([
                'email' => 'required|email',
            ]); 
            
            if(!$validated){
                return back()->with('status',$validation->errors());
    
            }
            $data['password']=Hash::make($request->password);
    	    if( User::where('email', $request->email)->update( $data ))
        	{
    			echo 0;
    		}
        }
}
