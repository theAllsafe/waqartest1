<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use App\Models\User;
use App\Models\VendorDetail;
use Hash;
use App\Models\Student;
use App\Models\Session;
use App\Models\Classes;
use App\Models\Section;
use App\Models\Category;
use App\Models\Like;
use Validator;
use DB;

class HomePageController extends Controller
{
    public function filter(Request $request){
		
            $search_session=$request->input('search_session');
            $search_category=$request->input('search_category');
            $getclass_id=$request->input('search_class');
            $search_section=$request->input('search_section');
            $users=User::join('tbl_student', 'users.id', '=', 'tbl_student.sid')
            ->join('users as school_table', 'school_table.id', '=', 'tbl_student.school_id')
            ->join('tbl_category','tbl_category.id','=','tbl_student.category_id')
            ->join('tbl_class','tbl_class.id','=','tbl_student.class_id')
            ->leftjoin('tbl_section','tbl_section.id','=','tbl_student.section_id')
            ->select('tbl_student.*','users.*','tbl_category.category_name','tbl_class.class','tbl_section.section_name','school_table.name as school_name')
            ->where(['users.create_type'=>2,'users.role'=>3])
            ->where('tbl_student.session','LIKE','%'.$search_session.'%')
            ->where('tbl_student.category_id','LIKE','%'.$search_category.'%')
            ->where('tbl_student.class_id','LIKE','%'.$getclass_id.'%')
            ->where('tbl_student.section_id','LIKE','%'.$search_section.'%')
            ->get();
		
		if( count( $users ) > 0 ){
		
			return response( [ 'success'=>true,'message'=>'Data found', 'data'=>$users ], 200 );
		
		}
		
		return response( [ 'success'=>false,'message'=>'Data Not found', 'data'=>[] ], 200 );
		
	}
    
    public function list($id){
		
		$data = User::join('tbl_institute','users.id','=','tbl_institute.institute_id')->where(['users.role'=>'2',"users.id"=>119])->select( '*')->get()->toArray();
		$data=$this->studentDetails($data);
		$data=$this->category($data);
		$data=$this->section($data);
		$data=$this->session($data);
// 		$data=$this->schools($data);
		if( count( $data ) > 0 ){
		
			return response( [ 'success'=>true,'message'=>'Data found', 'data'=>$data ], 200 );
		
		}
		
		return response( [ 'success'=>false,'message'=>'Data Not found', 'data'=>[] ], 200 );
		
	}
	
	public function studentDetails($data = array())
    {

        if ($data) {
            $x = array_map(function ($index) {
                
                $newdata = User::where(['role'=>'3'])->select( 'users.name','users.email','users.mobile_number','users.id')->get();
                $index['studentDetails'] = $newdata;
                return $index;
            }, $data);
        }
            return $x;
    }
    
	public function category($data = array())
    {

        if ($data) {
            $x = array_map(function ($index) {
                
                $newdata = Category::select('category_name','id')->get()->toArray();
                $newdata=$this->classes($newdata);
                $index['category'] = $newdata;
                return $index;
            }, $data);
        }
            return $x;
    }
    
    public function classes($data = array())
    {

        if ($data) {
            $x = array_map(function ($index) {
                // dd($index);
                $newdata = classes::where(['category_id' => $index['id']])->select('class','id')->get();
                
                $index['classes'] = $newdata;
                return $index;
            }, $data);
        }
            return $x;
    }
    
    public function section($data = array())
    {

        if ($data) {
            $x = array_map(function ($index) {
                
                $newdata = Section::select('section_name','id')->get();
                
                $index['section'] = $newdata;
                return $index;
            }, $data);
        }
            return $x;
    }
    
    public function session($data = array())
    {

        if ($data) {
            $x = array_map(function ($index) {
                
                $newdata = Session::select('session')->get();
                $index['session'] = $newdata;
                return $index;
            }, $data);
        }
            return $x;
    }
    
    public function schools($data = array())
    {

        if ($data) {
            $x = array_map(function ($index) {
                
                $newdata = User::where(['role'=>'2'])->select( 'users.name','users.email','users.mobile_number','users.id')->get();
                $index['schools'] = $newdata;
                return $index;
            }, $data);
        }
            return $x;
    }
    
    public function updateprofile( Request $request){
		
		$rules = [
		
		    'id'          =>'required',
		    
            'name'          =>'required',

            'mobile_number' =>'required',
			
			'email'         =>'required',
			
			'category_id'          =>'required',
		    
            'session'          =>'required',

            'class_id' =>'required',
			
			'section_id'         =>'required',
			
			'current_status' =>'required',
			
			'school_id'         =>'required'

        ];
		$id=$request->id;
        $validation = Validator::make( $request->all(), $rules );

        if( $validation->fails() ){

            return response( [ 'success'=>false, 'message'=>$validation->errors()->first() ] , 200 );

        }
        if($request->hasfile('image'))
        {
            $file=$request->file('image');
            $extension=$file->getClientOriginalExtension();
            $filename=time().'.'.$extension;
            $file->move('admin_assets/upload',$filename);
           // dd($filename);
            $data['image']="https://scsy.in/schoolbuddy/schoolbuddy/public/admin_assets/upload/".$filename;
        }
		$data['name'] = $request->name;
		$data['email'] = $request->email;
		$data['mobile_number'] = $request->mobile_number;
		$data['about'] = $request->about;
		
		$user = User::where( 'id', $id )->first();
			if( User::where( ['id'=>$request->id,'role'=>'3'] )->update( $data )){
			    $student=Student::where( ['sid'=>$request->id] )->get();
			 //   print_r(); exit;
			    if($student)
			    {
			        
			        $category_id=$request->input('category_id');
    			    $session=$request->input('session');
    			    $class_id=$request->input('class_id');
    			    $section_id=$request->input('section_id');
    			    $current_status=$request->input('current_status');
    			    $school_id=$request->input('school_id');
                    $len = count($category_id);
                    for($i=0;$len>$i;$i++)
                    {
                        $add1['sid'] = $request->id;
                        $add1['category_id']=$category_id[$i];
                        if(count($session)>$i)
                        {
                            $add1['session']=$session[$i];
                        }else
                        {
                            $add1['session']=null;
                        }
                        if(count($class_id)>$i)
                        {
                            $add1['class_id']=$class_id[$i];
                        }else
                        {
                            $add1['class_id']=null;
                        }
                        if(count($section_id)>$i)
                        {
                            $add1['section_id']=$section_id[$i];
                        }else
                        {
                            $add1['section_id']=null;
                        }
                        if(count($current_status)>$i)
                        {
                            $add1['current_status']=$current_status[$i];
                        }else
                        {
                            $add1['current_status']=null;
                        }
                        
                        if(count($school_id)>$i)
                        {
                            $add1['school_id']=$school_id[$i];
                        }else
                        {
                            $add1['school_id']=null;
                        }
                        
                        if(count($student)>$i)
                        {
                            $update=Student::where( ['id'=>$student[$i]->id] )->update($add1);
                        }
                        else
                        {
                            DB::table('tbl_student')->insert($add1);
                            // $update=Student::save($add1);
                        }
                        
                    }
                    // print_r($update); exit;
                    return response( [ 'success'=>true, 'message'=>'Profile updated successfully' ] , 200 );
                    
			    }else{
    			    $category_id=$request->input('category_id');
    			    $session=$request->input('session');
    			    $class_id=$request->input('class_id');
    			    $section_id=$request->input('section_id');
    			    $current_status=$request->input('current_status');
    			    $school_id=$request->input('school_id');
                    $len = count($category_id);
                    for($i=0;$len>$i;$i++)
                    {
                        $add1= new Student;
                        $add1['sid'] = $request->id;
                        $add1->category_id=$category_id[$i];
                        $add1->session=$session[$i];
                        $add1->class_id=$class_id[$i];
                        $add1->section_id=$section_id[$i];
                        $add1->current_status=$current_status[$i];
                        $add1->school_id=$school_id[$i];
                        $add1->save();
                    }
			    }
				// Student::where( ['sid'=>$request->id] )->update($data1);
				return response( [ 'success'=>true, 'message'=>'Profile updated successfully' ] , 200 );
				
			}
			return response( [ 'success'=>false, 'message'=>'Sorry try again' ] , 200 );
		
	}
	
	public function profiledata($id)
    {
        $data = User::where(['role'=>'3','id'=>$id])->select( 'users.name','users.email','users.image','users.mobile_number','users.about','users.id')->get()->toArray();
        $data=$this->educationDetails($data);
        if( count( $data ) > 0 ){
		
			return response( [  'success'=>true, 'message'=>'profile data', 'data'=>$data ], 200 );
		
		}
		
		return response( [ 'success'=>false, 'message'=>'profile Not data', 'data'=>[] ], 200 );
    }
    
    public function educationDetails($data = array())
    {

        if ($data) {
            $x = array_map(function ($index) {
                
                $newdata = Student::join('users','users.id','=','tbl_student.school_id')
                ->join('tbl_category','tbl_category.id','=','tbl_student.category_id')
                ->leftjoin('tbl_class','tbl_class.id','=','tbl_student.class_id')
                ->leftjoin('tbl_section','tbl_section.id','=','tbl_student.section_id')
                ->select( 'tbl_student.*','tbl_category.category_name','tbl_class.class','tbl_section.section_name','users.name as school_name')
                ->where(['sid' => $index['id']])
                ->get();
                $index['educationDetails'] = $newdata;
                return $index;
            }, $data);
        }
            return $x;
    }
	
}
