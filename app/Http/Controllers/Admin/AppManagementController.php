<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class AppManagementController extends Controller
{
    public function index()
    {
        $users=User::where([ 'role'=> '3','create_type'=>'1' ])->get();
        return view('admin.app.studentlist')->with('users',$users);
    }
}
