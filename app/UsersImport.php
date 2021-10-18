<?php
  
namespace App;
use Mail;
use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Hash;
use Auth;
use App\Models\Student;
class UsersImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $request)
    {
        $password="Schoolbuddy".rand(1000,999999);
        $add= new User;
        $add->user_id=Auth::user()->id;
        $add->name=$request['name'];
        $add->email=$request['email'];
        $add->mobile_number=$request['mobile_number'];
        $add->about=$request['about'];
        $add->role="3";
        $add->password=Hash::make($password);
        $add->save();
        return $add;
        // $add2= new Student;
        // $add2->sid=$add->id;
        // $add2->school_id=$request->input('school_id');
        // $add2->category_id=$request->input('category_id');
        // $add2->session=$request->input('session');
        // $add2->class_id=$request->input('class');
        // $add2->section_id=$request->input('section');
        // $add2->enrollment_number=$request->input('enrollment_number');
        // $add2->save();
        
        $data = [
        'email' => $request['email'],
        'password' => $password
        ];
        $email = array('email' => $request['email']);
        
        Mail::send('admin/mail', $data, function($message) use ($email){
        $message->to($email['email']);
        $message->from('dheeraj@8bittask.com','Uncat');
        });
    }
}