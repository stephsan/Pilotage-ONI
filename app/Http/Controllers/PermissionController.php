<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Support\Facades\Auth;

class PermissionController extends Controller
{
   
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(){
        $permissions=Permission::all();
        return view('permissions.index', compact('permissions'));
    }

    public function create(){
    return view('permissions.create');
    }

    public function store(Request $request){
        Permission::create([
            'name' => $request ['nom'],
            'for' => $request ['module']
        ]);
        return redirect()->route('permissions.index');
    }

    public function edit(Permission $permission)
    {

    //    $permission= Permission::find($permission);
    //    dd($permission);
        return view('permissions.update', compact('permission'));
    }

    public function update(Request $request, Permission $permission)
    {
        $permission->update([
            'name'=>$request['nom'],
            'for'=>$request['for'],
        ]);
        return redirect()->route('permissions.index');
    }

}
