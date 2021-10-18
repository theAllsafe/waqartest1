<?php

namespace App\Http\Controllers\Partner;
use Mail;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Student;
use App\Models\Session;
use App\Models\Classes;
use App\Models\Section;
use App\Models\Category;
use Hash;
use DB;
use App\UsersExport; 
use App\UsersImport;
use Excel;
use Auth;
use Illuminate\Http\Response;
class StudentRegisterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $school=User::where(['role'=>2])->get();
        $session=Session::get();
        $class=Classes::get();
        $category=Category::get();
        $Section=Section::get();
        if($_GET)
        {
            $search_institute=$_GET['search_institute'];
            $search_session=$_GET['search_session'];
            $search_category=$_GET['search_category'];
            $getclass_id=$_GET['getclass_id'];
            $search_section=$_GET['search_section'];
            $users=User::join('tbl_student', 'users.id', '=', 'tbl_student.sid')
            ->join('users as school_table', 'school_table.id', '=', 'tbl_student.school_id')
            ->join('tbl_category','tbl_category.id','=','tbl_student.category_id')
            ->join('tbl_class','tbl_class.id','=','tbl_student.class_id')
            ->leftjoin('tbl_section','tbl_section.id','=','tbl_student.section_id')
            ->select('tbl_student.*','users.*','tbl_category.category_name','tbl_class.class','tbl_section.section_name','school_table.name as school_name')
            ->where(['users.role'=>3])
            ->where('tbl_student.school_id','LIKE','%'.$search_institute.'%')
            ->where('tbl_student.session','LIKE','%'.$search_session.'%')
            ->where('tbl_student.category_id','LIKE','%'.$search_category.'%')
            ->where('tbl_student.class_id','LIKE','%'.$getclass_id.'%')
            ->where('tbl_student.section_id','LIKE','%'.$search_section.'%')
            ->get();
            return json_encode($users);
        }else{
        $users=User::join('tbl_student', 'users.id', '=', 'tbl_student.sid')
            ->join('users as school_table', 'school_table.id', '=', 'tbl_student.school_id')
            ->join('tbl_category','tbl_category.id','=','tbl_student.category_id')
            ->join('tbl_class','tbl_class.id','=','tbl_student.class_id')
            ->leftjoin('tbl_section','tbl_section.id','=','tbl_student.section_id')
            ->select('tbl_student.*','users.*','tbl_category.category_name','tbl_class.class','tbl_section.section_name','school_table.name as school_name')
            ->where(['users.role'=>3])
            ->get();
        }
        return view('partner.student.index',['users'=>$users,'session'=>$session,'class'=>$class,'school'=>$school,'category'=>$category,'Section'=>$Section]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $school=User::where(['role'=>2])->get();
        $session=Session::get();
        $class=Classes::get();
        $category=Category::get();
        $Section=Section::get();
        return view('partner.student.create',['session'=>$session,'class'=>$class,'school'=>$school,'category'=>$category,'Section'=>$Section]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated =$request->validate([
            'email' => 'required|string|email|max:50|unique:users',
        ]);
        if(!$validated){

            return back()->with('status',$validation->errors());

        }
        $password="Schoolbuddy".date("His").rand(1000,999999);
        $add= new User;
        if($request->hasfile('image'))
        {
            $file=$request->file('image');
            $extension=$file->getClientOriginalExtension();
            $filename=time().'.'.$extension;
            $file->move('admin_assets/upload',$filename);
            $add->image="https://scsy.in/schoolbuddy/schoolbuddy/public/admin_assets/upload/".$filename;
        }
        $add->user_id=Auth::user()->id;
        $add->name=$request->input('name');
        $add->email=$request->input('email');
        $add->mobile_number=$request->input('contact_number');
        $add->role="3";
        $add->password=Hash::make($password);
        $add->about=$request->input('about');
        $add->save();
        
        $add2= new Student;
        $add2->sid=$add->id;
        $add2->school_id=$request->input('school_id');
        $add2->category_id=$request->input('category_id');
        $add2->session=$request->input('session');
        $add2->class_id=$request->input('class');
        $add2->section_id=$request->input('section');
        $add2->enrollment_number=$request->input('enrollment_number');
        
        $add2->save();
        
        $data = [
        'email' => $request->input('email'),
        'password' => $password
        ];
        $email = array('email' => $request->input('email'));
        
        Mail::send('admin/mail', $data, function($message) use ($email){
        $message->subject('Schoolbuddy Login Credentials');
        $message->to($email['email']);
        $message->from('dheeraj@8bittask.com','Schoolbuddy');
        });
        
        return back()->with('status','Student create successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $users=User::where('id',$id)->first();
        $student=User::join('tbl_student', 'users.id', '=', 'tbl_student.school_id')
            ->join('tbl_category','tbl_category.id','=','tbl_student.category_id')
            ->leftjoin('tbl_class','tbl_class.id','=','tbl_student.class_id')
            ->leftjoin('tbl_section','tbl_section.id','=','tbl_student.section_id')
            ->select('tbl_student.*','users.name','tbl_category.category_name','tbl_class.class','tbl_section.section_name','users.name as school_name')
            ->where(['tbl_student.sid'=>$id])
            ->get();
        return view('partner.student.show',['users'=>$users,'student'=>$student]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $student=User::join('tbl_student', 'users.id', '=', 'tbl_student.sid')
            ->leftjoin('tbl_class','tbl_class.id','=','tbl_student.class_id')
            ->select('tbl_student.school_id','tbl_class.class','tbl_student.category_id','tbl_student.session','tbl_student.class_id','tbl_student.section_id','tbl_student.enrollment_number','users.*')
            ->where(['users.id'=>$id])
            ->first();
        $school=User::where(['role'=>2])->get();
        $session=Session::get();
        $class=Classes::get();
        $category=Category::get();
        $section=Section::get();
        return view('partner.student.edit',['school'=>$school,'student'=>$student,'session'=>$session,'class'=>$class,'category'=>$category,'section'=>$section]);
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
        $validated =$request->validate([
            'email' => 'required|string|email|max:50|unique:users',
        ]);
        if(!$validated){

            return back()->with('status',$validation->errors());

        }
        $add= User::find($id);
        if($request->hasfile('image'))
        {
            $file=$request->file('image');
            $extension=$file->getClientOriginalExtension();
            $filename=time().'.'.$extension;
            $file->move('admin_assets/upload',$filename);
           // dd($filename);
            $add->image="https://scsy.in/schoolbuddy/schoolbuddy/public/admin_assets/upload/".$filename;
        }
        else{
            $add->image=$request->input('oldimage');;
        }
        $add->name=$request->input('name');
        $add->email=$request->input('email');
        $add->mobile_number=$request->input('contact_number');
        $add->about=$request->input('about');
        $add->update();
        
        $add2= Student::where(['sid'=>$id])->first();
        $add2->school_id=$request->input('school_id');
        $add2->category_id=$request->input('category_id');
        $add2->session=$request->input('session');
        $add2->class_id=$request->input('class');
        $add2->section_id=$request->input('section');
        $add2->enrollment_number=$request->input('enrollment_number');
        $add2->update();
        return back()->with('status','Student update successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $users=User::findOrFail($id);
        $users->delete();
        return back()->with('status','Student Delete successfully');
    }
    
    public function iimport(Request $request) 
    {
        $arr=[];
        if($request->hasFile('file')){
            $path = $request->file('file')->getRealPath();
            $data = Excel::import($path,request()->file('file'));
            if($data){
                foreach ($data as $key => $value) {
                    $arr[] = ['name' => $value->name, 'email' => $value->email];
                }
                dd($arr);
                if(!empty($arr)){
                    \DB::table('products')->insert($arr);
                    dd('Insert Record successfully.');
                }
            }
        }
    //   $example =  Excel::import(new UsersImport,request()->file('file'));
       return back()->with('status','Student create successfully');
    }
    
    public function export() 
    {
        
         return Excel::download(new UsersExport, 'users.xlsx');
    }
    
    public function getclass(Request $request)
    {
        $id=$request->input('id');
        $student=Classes::where('category_id',$id)->get();
        // dd($student);
        echo "<option value=''>Select Class</option>";
       foreach($student as  $val)
       {
        echo "<option value=".$val->id.">".$val->class."</option>"; 
        }
    }
    
    public function getsection(Request $request)
    {
        $id=$request->input('id');
        $student=Section::where('class_id',$id)->get();
        // dd($student);
        echo "<option value=''>Select Section</option>";
       foreach($student as  $val)
       {
        echo "<option value=".$val->id.">".$val->section_name."</option>"; 
        }
    }
    
    public function import(Request $request)
    {
    $file = $request->file('file');
    if ($file) {
    $filename = $file->getClientOriginalName();
    $extension = $file->getClientOriginalExtension(); //Get extension of uploaded file
    $tempPath = $file->getRealPath();
    $fileSize = $file->getSize(); //Get size of uploaded file in bytes
    //Check for file extension and size
    $this->checkUploadedFileProperties($extension, $fileSize);
    //Where uploaded file will be stored on the server 
    $location = 'uploads'; //Created an "uploads" folder for that
    // Upload file
    $file->move($location, $filename);
    // In case the uploaded file path is to be stored in the database 
    $filepath = public_path($location . "/" . $filename);
    // Reading file
    $file = fopen($filepath, "r");
    $importData_arr = array(); // Read through the file and store the contents as an array
    $i = 0;
    //Read the contents of the uploaded file 
    while (($filedata = fgetcsv($file, 1000, ",")) !== FALSE) {
    $num = count($filedata);
    // Skip first row (Remove below comment if you want to skip the first row)
    if ($i == 0) {
    $i++;
    continue;
    }
    for ($c = 0; $c < $num; $c++) {
    $importData_arr[$i][] = $filedata[$c];
    }
    $i++;
    }
    fclose($file); //Close after reading
    $j = 0;
    foreach ($importData_arr as $key => $importData) {
    // $name = $importData[0]; //Get user names
    // $email = $importData[1]; //Get the user emails
    $user=User::where('email',$importData[1])->get();
    // dd($user);
    if(count($user) > 0){

        return back()->with('status',"Email Id Duplicate");

    }
    $add= new User;
    $password="Schoolbuddy".rand(1000,999999);
    $add= new User;
    $add->user_id=Auth::user()->id;
    $add->name=$importData[0];
    $add->email=$importData[1];
    $add->mobile_number=$importData[2];
    $add->about=$importData[3];
    $add->role="3";
    $add->password=Hash::make($password);
    $add->save();
    
    $add2= new Student;
    $add2->sid=$add->id;
    $add2->school_id=$request->input('school_id');
    $add2->category_id=$request->input('category_id');
    $add2->session=$request->input('session');
    $add2->class_id=$request->input('class');
    $add2->section_id=$request->input('section');
    $add2->enrollment_number=$request->input('enrollment_number');
    $add2->save();
    $j++;
    $data = [
        'email' => $importData[1],
        'password' => $password
        ];
        $email = array('email' => $importData[1]);
        
        Mail::send('admin/mail', $data, function($message) use ($email){
        $message->subject('Schoolbuddy Login Credentials');
        $message->to($email['email']);
        $message->from('dheeraj@8bittask.com','Schoolbuddy');
        });
    }
        return back()->with('status',"$j records successfully uploaded");
    } else {
    //no file was uploaded
        return back()->with('status',"No file was uploaded");
    }
    }
    public function checkUploadedFileProperties($extension, $fileSize)
    {
    $valid_extension = array("csv", "xlsx"); //Only want csv and excel files
    $maxFileSize = 2097152; // Uploaded file size limit is 2mb
    if (in_array(strtolower($extension), $valid_extension)) {
    if ($fileSize <= $maxFileSize) {
    } else {
    throw new \Exception('No file was uploaded', Response::HTTP_REQUEST_ENTITY_TOO_LARGE); //413 error
    }
    } else {
    throw new \Exception('Invalid file extension', Response::HTTP_UNSUPPORTED_MEDIA_TYPE); //415 error
    }
    }
}
