<?php

namespace App\Http\Controllers;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleController extends Controller
{
    //
    public function index(){
        $roles=Role::orderBy('updated_at', 'desc')->get();
                return view('roles.index',compact('roles'));
            //  }
    }

    public function create(){
        if (Auth::user()) {
            $permissions=Permission::all();
            return view('roles.create', compact('permissions'));
             }
    }

    public function store(Request $request)
    {
     if (Auth::user()) {
        $role= Role::create([
            'nom'=> $request ['nom'],
        ]);
        $role->permissions()->sync($request->permission);
        //flash("Role créer avec succes!!!")->error();
        return redirect(route('role.index'));
     }
     else{
         //flash("Vous n'avez pas le droit d'acceder à cette resource. Veillez contacter l'administrateur!!!")->error();
         return redirect()->back();
     }

    }

    public function edit(Role $role)
    {
         if (Auth::user()) {
            $permissions=Permission::all()->where('supprimer', '!=', 1 );
            return view('roles.update', compact('role', 'permissions'));
         }
         else{
            // flash("Vous n'avez pas le droit d'acceder à cette resource. Veillez contacter l'administrateur!!!")->error();
             return redirect()->back();
         }
    }
    public function update(Request $request, Role $role)
    {
         if (Auth::user()) {
        $role->update([
            'nom'=>$request['nom'],
        ]);
        $role->permissions()->sync($request->permissions);
        //flash("Role modifié avec success!!!")->success();
        return redirect(route('role.index'));
     }
    //  else{
    //      flash("Vous n'avez pas le droit d'acceder à cette resource. Veillez contacter l'administrateur!!!")->success();
    //      return redirect()->back();
    //  }
    }

}