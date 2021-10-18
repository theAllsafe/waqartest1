<?php

namespace App\Http\Controllers\Partner;
use Auth;
use Hash;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Partner;
class PartnerLoginController extends Controller
{
    public function login()
    {
        //'password' => Hash::make('admin@123')
        return view('partner.login');
    }
    public function makelogin(Request $request)
    {
        $credentials = [
            'email' => $request['email'],
            'password' => $request['password'],
            'role' => '2',
            'login_status' => '1',
        ];

        if(Auth::attempt($credentials)) {
            $value = $request->session()->get('key', $credentials);
            return redirect()->route('partner.dashboard');       
        }

        return redirect('partner/login')->with('error', 'Oppes! You have entered invalid credentials');
    }

    // ------------------ [ User Dashboard Section ] ---------------------
    public function dashboard() {

        // check if user logged in
        if(Auth::check()) {
            return view('partner.dashboard');
        }

        return redirect('partner.login')->with('error', 'Oopps! You do not have access');
    }
    
    public function profile() 
    {
        if(Auth::check()) {
            return view('partner.profile');
        }
        return redirect('partner/login')->with('error', 'Oopps! You do not have access');
    }
    
    public function updateprofile(Request $request) 
    {
        if(Auth::check())
        {
        	$validated =$request->validate([
	            'email' => 'required|string|email|max:50|unique:users',
	        ]);
	        if(!$validated){
	
	            return back()->with('status',$validation->errors());
	
	        }
	        if($request->hasfile('image'))
	        {
	            $file=$request->file('image');
	            $extension=$file->getClientOriginalExtension();
	            $filename=time().'.'.$extension;
	            $file->move('admin_assets/upload',$filename);
	            $data['profile_image']=$filename;
	        }
        	$data['name'] = $request->name;
        	$data['email'] = $request->email;
        	if( User::where('id', Auth::user()->id)->update( $data ))
        	{
			return back()->with('status','Profile update successfully');
		}
		return back()->with('status','Not update profile');
        }
        return redirect('partner/login')->with('error', 'Oopps! You do not have access');
    }
    
    public function changepassword(Request $request) 
    {
        if(Auth::check())
        {        	
            $password=Auth::user()->password;
            // $old_password = Hash::check('admin@123');
            // dd($password.$old_password);
        	$new_password = $request->new_password;
        	$confirm_password = $request->confirm_password;
        	if((Hash::check($request->post('old_password'), Auth::user()->password)))
        	{
        	    if($new_password==$confirm_password)
            	{
                	$data['password']=Hash::make($new_password);
            	    if( User::where('id', Auth::user()->id)->update( $data ))
                	{
                	    $data['password']=Hash::make($new_password);
            			return back()->with('change_password_status','Password update successfully');
            		}
            	}
            	else
            	{
            	    return back()->with('change_password_status','New & Confirm Password not match');
            	}
        	}
        	else
        	{
        	    return back()->with('change_password_status','Old Password not match');
        	}
        	
		return back()->with('status','Not update profile');
        }
        return redirect('partner/login')->with('error', 'Oopps! You do not have access');
    }
    
    public function instituteimage(Request $request) 
    {
        if(Auth::check())
        {
	        if($request->hasfile('institute_image'))
	        {
	            $file=$request->file('institute_image');
	            $extension=$file->getClientOriginalExtension();
	            $filename=time().'.'.$extension;
	            $file->move('admin_assets/upload',$filename);
	            $data['institute_image']=$filename;
	        }
        	if( Partner::where('partner_id', Auth::user()->id)->update( $data ))
        	{
			return back()->with('instituteimage_status','Institute image update successfully');
		}
		return back()->with('instituteimage_status','Not update Institute image');
        }
        return redirect('partner/login')->with('error', 'Oopps! You do not have access');
    }

    public function logout()
    {
        Auth::logout();
  
        return redirect('partner/login')->with('error', 'You logout');
    
    }
  
}
