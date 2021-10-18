<?php
  
namespace App;
use Mail;
use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Hash;
use Auth;
use App\Models\Institute;
class PartnerImport implements ToModel, WithHeadingRow
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
        $add->role="2";
        $add->about=$request['about_school'];
        $add->password=Hash::make($password);
        $add->save();
        
        $add2= new Institute;
        $add2->institute_id=$add->id;
        $add2->telephone_number=$request['telephone_number'];
        $add2->fax_number=$request['fax_number'];
        $add2->address_line_1=$request['address_line_1'];
        $add2->address_line_2=$request['address_line_2'];
        $add2->city=$request['city'];
        $add2->state=$request['state'];
        $add2->zip=$request['zip'];
        $add2->country=$request['country'];
        $add2->save();
        
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