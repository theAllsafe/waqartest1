<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use App\Models\User;
use App\Models\VendorDetail;
use Hash;
use App\Models\Student;
use App\Models\Like;
use Validator;
use DB;

class AuthController extends Controller
{
    private $apiToken;
      public function __construct()
      {
        // Unique Token
        $this->apiToken = uniqid(base64_encode(rand(10000,99999)));
      }
    public function school_name(){
		
		$school_name = User::where( 'role', '2' )->select( 'users.id','users.name')->get();
		
		if( count( $school_name ) > 0 ){
		
			return response( [ 'success'=>true,'message'=>'School name found', 'data'=>$school_name ], 200 );
		
		}
		
		return response( [ 'success'=>false,'message'=>'School name Not found', 'data'=>[] ], 200 );
		
	}
	
    public function signup( Request $request ){
		
		
		$rules = [

            'name'              =>'required|min:4',
            
            'contact_number'    =>'required',

            'password'          =>'required|min:6',

            'email'  			=>'required|email|unique:users',

        ];

        $validation = Validator::make( $request->all(), $rules );

        if( $validation->fails() ){
            
            return response( [ 'success'=> false, 'message'=>$validation->messages()->first() ] , 200 );

        } 
        if( !User::where( 'email', $request->email )->first() ){

			$request->merge( [ 'role'=> '3','create_type'=>'1' ] );
			
			$request[ 'password' ] = Hash::make( $request->password );
			$request[ 'mobile_number' ] = $request->contact_number;
			
			$user = User::create( $request->all() );
			
			return response( [ 'success'=>true, 'message'=>'Sign up successfull', 'data'=>$user->id, '_access_token'=>$this->apiToken],200 );
            
        }
        else{

            return response( [ 'success'=>false, 'data'=>[] ], 200 );

        }
		
	}
	public function signin( Request $request ){
		
		$rules = [

            'email'          =>'required',

            'password'          =>'required'

        ];

        $validation = Validator::make( $request->all(), $rules );

        if( $validation->fails() ){

            return response( [ 'success'=>false, 'message'=>$validation->errors()->first() ] , 200 );

        }
		$user = User::where( 'email', $request->email )->first();
		if( $user && Hash::check( $request->password, $user->password ) ){
			
			return response( [ 'success'=>true, 'message'=> 'Login successful', 'user'=>$user,'token'=>$this->apiToken] , 200 );
			
		}
		
		return response( [ 'success'=>false, 'message'=>'Wrong email and password combination' ] , 200 );
		
	}
	
	public function studentlist()
    {
        $users=User::join('tbl_student','tbl_student.sid','=','users.id')->where('users.role','3')->get();
        if( count( $users ) > 0 ){
		
			return response( [  'success'=>true, 'message'=>'Student found', 'student'=>$users ], 200 );
		
		}
		
		return response( [ 'success'=>false, 'message'=>'Student Not found', 'student'=>[] ], 200 );
    }
    
	public function schoollist(){
	    $user_id=$_GET['user_id'];
        if($_GET){
            $school_name=$_GET['school_name'];
            $city=$_GET['city'];
            if($city){
                $school = User::join('tbl_institute','users.id','=','tbl_institute.institute_id')->where( 'users.role', '2' )->where('tbl_institute.city','LIKE','%'.$city.'%')->select( 'users.id as uid','users.name','users.image','users.mobile_number','users.about','users.email','tbl_institute.*')->get()->toArray();   
            }else{
                $school = User::join('tbl_institute','users.id','=','tbl_institute.institute_id')->where( 'users.role', '2' )->where('users.name','LIKE','%'.$school_name.'%')->select( 'users.id as uid','users.name','users.image','users.mobile_number','users.about','users.email','tbl_institute.*')->get()->toArray();   
            }
        }else{
            $school = User::join('tbl_institute','tbl_institute.institute_id','=','users.id')->where( 'users.role', '2' )->select( 'users.id as uid','users.name','users.image','users.mobile_number','users.about','users.email','tbl_institute.*')->get()->toArray();
        }
        if($school){
            $school=$this->like($school,$user_id);
        }
        if( count( $school ) > 0 ){
            return response( [ 'success'=>true,'message'=>'School found', 'data'=>$school ], 200 );
        }else{
            return response( [ 'success'=>false,'message'=>'School Not found', 'data'=>[] ], 200 );
        }
	}
	
	public function like($data,$user_id)
    {
        if ($data) {
            $x = array_map(function ($index) use ($user_id) {
                $newdata = Like::where(['school_id' => $index['uid'],'user_id' => $user_id])->get();
                $index['Like'] = $newdata;
                return $index;
            }, $data);
        }
            return $x;
    }
	
	public function school_like( Request $request ){
		
		
		$rules = [
            'school_id'          =>'required',
            
            'user_id'          =>'required',
            
            'is_like'          =>'required',

        ];

        $validation = Validator::make( $request->all(), $rules );

        if( $validation->fails() ){
            
            return response( [ 'success'=> false, 'message'=>$validation->messages()->first() ] , 200 );

        } 
            $data['is_like']=$request->is_like;
            if( Like::where( ['school_id'=>$request->school_id,'user_id'=>$request->user_id] )->update( $data )){
    			return response( [ 'success'=>true, 'message'=>'updated successfully' ] , 200 );
    			
    		}
			$add2= new Like;
			$add2->school_id=$request->input('school_id');
            $add2->user_id=$request->input('user_id');
            $add2->is_like=$request->input('is_like');
            $add2->save();
			return response( [ 'success'=>true, 'message'=>'Add successfull'],200 );
            
		
	}
	
	public function favorite(){
	    $user_id=$_GET['user_id'];
        if($_GET){
            $school_name=$_GET['school_name'];
            $city=$_GET['city'];
            if($city){
                $school = User::join('tbl_institute','users.id','=','tbl_institute.institute_id')->join('tbl_school_like','users.id','=','tbl_school_like.school_id')->where(['tbl_school_like.user_id'=>$user_id,'users.role'=>'2'])->where('tbl_institute.city','LIKE','%'.$city.'%')->select( 'tbl_school_like.is_like','users.id as uid','users.name','users.image','users.mobile_number','users.about','users.email','tbl_institute.*')->get()->toArray();   
            }else{
                $school = User::join('tbl_institute','users.id','=','tbl_institute.institute_id')->join('tbl_school_like','users.id','=','tbl_school_like.school_id')->where(['tbl_school_like.user_id'=>$user_id,'users.role'=>'2'])->where('users.name','LIKE','%'.$school_name.'%')->select( 'tbl_school_like.is_like','users.id as uid','users.name','users.image','users.mobile_number','users.about','users.email','tbl_institute.*')->get()->toArray();   
            }
        }else{
            $school = User::join('tbl_institute','tbl_institute.institute_id','=','users.id')->join('tbl_school_like','users.id','=','tbl_school_like.school_id')->where(['tbl_school_like.user_id'=>$user_id,'users.role'=>'2'])->select( 'tbl_school_like.is_like','users.id as uid','users.name','users.image','users.mobile_number','users.about','users.email','tbl_institute.*')->get()->toArray();
        }
        if( count( $school ) > 0 ){
            return response( [ 'success'=>true,'message'=>'School found', 'data'=>$school ], 200 );
        }else{
            return response( [ 'success'=>false,'message'=>'School Not found', 'data'=>[] ], 200 );
        }
	}
}
