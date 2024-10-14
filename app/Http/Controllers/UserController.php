<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\User;
use App\Models\Antenne;
use App\Models\Valeur;
use App\Models\Entite;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        if (Auth::user()->can('gerer_user')) {
            $users= User::all();
            return view('user.index', compact("users"));
        }
        else{
            return redirect()->back()->with('error',"Vous n'avez pas la permission pour effectuer cette action!");
        }
    }

    public function create(){
        if (Auth::user()->can('gerer_user')) {
            $roles= Role::all();   
            $fonctions= Valeur::where('parametre_id',8)->get();  
            $antennes= Antenne::all();
            $entites= Entite::all();            
            return view("user.create", compact('fonctions',"roles", "antennes",'entites'));
        }
        else{
            return redirect()->back()->with('error',"Vous n'avez pas la permission pour effectuer cette action!");
        }
    }

    public function store(Request $request){
        if (Auth::user()->can('gerer_user')) {
            $request->validate([
                "nom"=>"required",
                "email"=>"required|email"             
            ]);
           $user= User::create([
                "name"=>$request['nom'],
                "matricule"=>$request['matricule'],
                "fonction"=>$request['fonction'],
                "email"=>$request['email'],
                'Prenom'=> $request ['prenom'],                
                'Telephone'=> $request ['telephone'],
                'antenne_id'=> $request ['antenne'],
                'entite_id'=> $request ['entite'],
                'email' => $request['email'],
                'password' => bcrypt('onibf@2024')
            ]);
            $user->roles()->sync($request->roles);
            return redirect()->route("user.index");
        }
        else{
        // flash("Vous n'avez pas le droit d'acceder à cette resource. Veillez contacter l'administrateur!!!")->success();
            return redirect()->back()->with('error',"Vous n'avez pas la permission pour effectuer cette action!");
        }
    }

    public function edit(User $user)
    {
    if (Auth::user()) {
            $roles= Role::all();
            $entites= Entite::all();  
            $fonctions= Valeur::where('parametre_id',8)->get();    
            $antennes= Antenne::all();             
        return view("user.update",compact(['fonctions',"user","roles",'antennes','entites']));
     }
     else{
         flash("Vous n'avez pas le droit d'acceder à cette resource. Veillez contacter l'administrateur!!!")->error();
         return redirect()->back();
     }
    }

    public function update(Request $request, User $user)
    {
     if (Auth::user()) {
        $request->validate([
            'nom'=>"required",
            'email'=>"required|email"
        ]);
        $user->update([
            "name"=>$request['nom'],
            "email"=>$request['email'],
            "matricule"=>$request['matricule'],
            "fonction"=>$request['fonction'],
            'Prenom'=> $request ['prenom'],
            'antenne_id'=> $request ['antenne'], 
            'entite_id'=> $request ['entite'],               
            'Telephone'=> $request ['telephone']                         
        ]);
        $user->roles()->sync($request->roles);
        return redirect()->route("user.index");
    }
       
    }
    public function logout(Request $request) {
            Auth::logout();
            return redirect()->route('login');
       
    }
    public function login(){
        return view('auth.login');
    }
}
