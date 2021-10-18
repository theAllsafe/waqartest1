<?php

namespace App\Http\Controllers\Admin;
use Mail;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Institute;
use Hash;
use Auth;
use App\PartnerImport;
use Excel;
class PartnerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users=User::join('tbl_institute','users.id','=','tbl_institute.institute_id')->select('users.*','tbl_institute.telephone_number','tbl_institute.fax_number','tbl_institute.address_line_1','tbl_institute.address_line_2','tbl_institute.city','tbl_institute.state','tbl_institute.zip','tbl_institute.country')->where('users.role','2')->get();
        return view('admin.partner.index')->with('users',$users);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.partner.create');
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
            'name' => 'required|string',
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
        $add->mobile_number=$request->input('mobile_number');
        $add->role="2";
        $add->about=$request->input('about_school');
        $add->password=Hash::make($password);
        $add->save();
        
        $add2= new Institute;
        $add2->institute_id=$add->id;
        $add2->telephone_number=$request->input('telephone_number');
        $add2->fax_number=$request->input('fax_number');
        $add2->address_line_1=$request->input('address_line_1');
        $add2->address_line_2=$request->input('address_line_2');
        $add2->city=$request->input('city');
        $add2->state=$request->input('state');
        $add2->zip=$request->input('zip');
        $add2->country=$request->input('country');
        $add2->save();
        
        $data = [
        'email' => $request->input('email'),
        'password' => $password
        ];
        $email = array('email' => $request->input('email'));
        
        Mail::send('admin/mail', $data, function($message) use ($email){
        $message->to($email['email']);
        $message->from('dheeraj@8bittask.com','Uncat');
        });
        
        return back()->with('status','Institute create successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $school=User::join('tbl_institute','users.id','=','tbl_institute.institute_id')->select('users.*','tbl_institute.telephone_number','tbl_institute.fax_number','tbl_institute.address_line_1','tbl_institute.address_line_2','tbl_institute.city','tbl_institute.state','tbl_institute.zip','tbl_institute.country')->where('users.id',$id)->first();
        return view('admin.partner.edit',['school'=>$school]);
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
        $add->mobile_number=$request->input('mobile_number');
        $add->about=$request->input('about_school');
        $add->update();
        
        $add2= Institute::where(['institute_id'=>$id])->first();
        $add2->telephone_number=$request->input('telephone_number');
        $add2->fax_number=$request->input('fax_number');
        $add2->address_line_1=$request->input('address_line_1');
        $add2->address_line_2=$request->input('address_line_2');
        $add2->city=$request->input('city');
        $add2->state=$request->input('state');
        $add2->zip=$request->input('zip');
        $add2->country=$request->input('country');
        $add2->update();
        return back()->with('status','Institute update successfully');
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
        
        $partner=Institute::where(['institute_id'=>$id])->first();
        $partner->delete();
        return back()->with('status','Institute Delete successfully');
    }
    
    public function status(Request $request)
    {
        $id=$request->input('id');
        $add= User::find($id);
        $add->login_status=$request->input('status');
        $add->update();
        echo 0;
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
        $password="Schoolbuddy".rand(1000,999999);
        $add= new User;
        $add->user_id=Auth::user()->id;
        $add->name=$importData[0];
        $add->email=$importData[1];
        $add->mobile_number=$importData[2];
        $add->role="2";
        $add->about=$importData[3];
        $add->password=Hash::make($password);
        $add->save();
        
        $add2= new Institute;
        $add2->institute_id=$add->id;
        $add2->telephone_number=$importData[4];
        $add2->fax_number=$importData[5];
        $add2->address_line_1=$importData[6];
        $add2->address_line_2=$importData[7];
        $add2->city=$importData[8];
        $add2->state=$importData[9];
        $add2->zip=$importData[10];
        $add2->country=$importData[11];
        $add2->save();
        $j++;
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
