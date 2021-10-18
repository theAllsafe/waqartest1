<?php

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Session;
use Auth;
class SessionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users=Session::where('partner_id',Auth::user()->id)->get();
        return view('partner.session.index')->with('users',$users);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('partner.session.create');
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
            'session' => 'required',
        ]);
        if(!$validated){

            return back()->with('status',$validation->errors());

        }
        $category=$request->input('session');
        $len = count($category);
        
        for($i=0;$len>$i;$i++)
        {
            $add1= new Session;
            $add1->partner_id=Auth::user()->id;
            $add1->session=$category[$i];
            $add1->save();
        }
        
        
        return back()->with('status','Session create successfully');
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
        $session=Session::find($id);
        return view('partner.session.edit',['session'=>$session]);
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
        $add=Session::find($id);
        $add->session=$request->input('session');
        $add->update();
        return back()->with('status','Session update successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $users=Session::findOrFail($id);
        $users->delete();
        return back()->with('status','Session Delete successfully');
    }
}
