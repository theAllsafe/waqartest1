<?php

namespace App\Http\Controllers\Partner;
use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class CATEGORYController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users=Category::get();
        return view('partner.category.index')->with('users',$users);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('partner.category.create');
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
            'category' => 'required',
        ]);
        if(!$validated){

            return back()->with('status',$validation->errors());

        }
        $category=$request->input('category');
        $len = count($category);
        
        for($i=0;$len>$i;$i++)
        {
            $add1= new Category;
            $add1->category_name=$category[$i];
            $add1->save();
        }
        
        return back()->with('status','Category create successfully');
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
        $class=Category::find($id);
        return view('partner.category.edit',['class'=>$class]);
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
        $add=Category::find($id);
        $add->category_name=$request->input('category_name');
        $add->update();
        return back()->with('status','Category update successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $users=Category::findOrFail($id);
        $users->delete();
        return back()->with('status','Category Delete successfully');
    }
}
