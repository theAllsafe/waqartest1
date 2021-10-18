<?php

namespace App\Http\Controllers\Admin;
use Mail;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Partner;
use Hash;
use Auth;
class CreateAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users=User::where('role','1')->get();
        return view('admin.admin.index')->with('users',$users);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.admin.create');
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
        $add->partner_id=Auth::user()->id;
        $add->name=$request->input('name');
        $add->email=$request->input('email');
        $add->role="1";
        $add->password=Hash::make($password);
        $add->save();
        
        $add2= new Partner;
        $add2->partner_id=$add->id;
        $add2->education_information=$request->input('education_information');
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
        
        return back()->with('status','Admin create successfully');
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
        $admin=User::find($id);
        return view('admin.admin.edit',['admin'=>$admin]);
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
        $add->name=$request->input('name');
        $add->email=$request->input('email');
        $add->update();
        return back()->with('status','Admin update successfully');
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
        return back()->with('status','Admin Delete successfully');
    }
    
    public function status(Request $request)
    {
        $id=$request->input('id');
        $add= User::find($id);
        $add->login_status=$request->input('status');
        $add->update();
        echo 0;
    }
}
