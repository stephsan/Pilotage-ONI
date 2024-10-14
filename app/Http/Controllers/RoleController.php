<?php

namespace App\Http\Controllers;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(){
        if (Auth::user()->can('gerer_user')) {
        $roles=Role::orderBy('updated_at', 'desc')->get();
                return view('roles.index',compact('roles'));
            }
            else{
                return redirect()->back()->with('error',"Vous n'avez pas la permission pour effectuer cette action!");
            }
    }

    public function create(){
        if (Auth::user()->can('gerer_user')) {
            $permissions=Permission::all();
            return view('roles.create', compact('permissions'));
        }
        else{
            return redirect()->back()->with('error',"Vous n'avez pas la permission pour effectuer cette action!");
        }
    }

    public function store(Request $request)
    {
        if (Auth::user()->can('gerer_user')) {
        $role= Role::create([
            'nom'=> $request ['nom'],
        ]);
        $role->permissions()->sync($request->permission);
        //flash("Role créer avec succes!!!")->error();
        return redirect(route('role.index'));
     }
     else{
         //flash("Vous n'avez pas le droit d'acceder à cette resource. Veillez contacter l'administrateur!!!")->error();
         return redirect()->back()->with('error',"Vous n'avez pas la permission pour effectuer cette action!");
     }

    }

    public function edit(Role $role)
    {
        if (Auth::user()->can('gerer_user')) {
            $permissions=Permission::all()->where('supprimer', '!=', 1 );
            return view('roles.update', compact('role', 'permissions'));
         }
         else{
            // flash("Vous n'avez pas le droit d'acceder à cette resource. Veillez contacter l'administrateur!!!")->error();
             return redirect()->back()->with('error',"Vous n'avez pas la permission pour effectuer cette action!");
         }
    }
    public function update(Request $request, Role $role)
    {
        if (Auth::user()->can('gerer_user')) {
        $role->update([
            'nom'=>$request['nom'],
        ]);
        $role->permissions()->sync($request->permissions);
        //flash("Role modifié avec success!!!")->success();
        return redirect(route('role.index'));
     }
      else{
        // flash("Vous n'avez pas le droit d'acceder à cette resource. Veillez contacter l'administrateur!!!")->success();
          return redirect()->back()->with('error',"Vous n'avez pas la permission pour effectuer cette action!");
      }
    }

}