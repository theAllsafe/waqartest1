<?php

namespace App\Http\Controllers\Partner;
use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Classes;
use App\Models\Category;

class ClassController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users=Classes::join('tbl_category','tbl_category.id','=','tbl_class.category_id')->select('tbl_class.*','tbl_category.category_name')->get();
        $category=Category::get();
        return view('partner.class.index')->with(['users'=>$users,'category'=>$category]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('partner.class.create');
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
            'class' => 'required',
        ]);
        if(!$validated){

            return back()->with('status',$validation->errors());

        }
        $category=$request->input('class');
        $len = count($category);
        
        for($i=0;$len>$i;$i++)
        {
            $add1= new Classes;
            $add1->category_id=$request->input('category');
            $add1->class=$category[$i];
            $add1->save();
        }
        
        return back()->with('status','Class create successfully');
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
        $category=Category::get();
        $class=Classes::find($id);
        return view('partner.class.edit',['class'=>$class,'category'=>$category]);
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
        $add=Classes::find($id);
        $add->category_id=$request->input('category');
        $add->class=$request->input('class');
        $add->update();
        return back()->with('status','Class update successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $users=Classes::findOrFail($id);
        $users->delete();
        return back()->with('status','Class Delete successfully');
    }
}
