<?php

namespace App\Http\Controllers;

use App\Models\Parametre;
use App\Models\Valeur;
use Illuminate\Http\Request;

class ValeurController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['listevakeur', 'selection']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $parametres = Parametre::all();
        $valeurs= Valeur::with("parametre")->orderBy('updated_at', 'desc')->get();
        return view('valeur.index', compact('valeurs', 'parametres'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $valeurs = Valeur::all();
        $parametres = Parametre::all();
        return view('valeur.create', compact('parametres','valeurs'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Valeur::create([
            'parametre_id'=>$request->parametre,
            'valeur_id'=>$request->parent,
            'libelle'=>$request->libelle,
            'description'=>$request->description,
            'code'=>$request->code,
        ]);
        return redirect(route('valeur.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Valeur  $valeur
     * @return \Illuminate\Http\Response
     */
    public function show(Valeur $valeur)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Valeur  $valeur
     * @return \Illuminate\Http\Response
     */
    public function edit(Valeur $valeur)
    {
        $vals= Valeur::all();
        $parametres= Parametre::all();
        return view('valeur.edit',compact('valeur', 'parametres', 'vals'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Valeur  $valeur
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Valeur $valeur)
    {
        $valeur->parametre_id= $request->parametre;
        $valeur->valeur_id= $request->parent;
        $valeur->libelle=$request->libelle;
        $valeur->description= $request->description;
        $valeur->save();
        return redirect(route('valeur.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Valeur  $valeur
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       Valeur::destroy($id);
       return redirect()->route("valeur.index");
    }
    public function selection(Request $request)
    {
        $idparent_val = $request->idparent_val;
        $id_param = $request->id_param;

        $parent = $request->parent;
        $valeurs = Valeur::where(['parametre_id' => $id_param , 'valeur_id' =>$idparent_val ])->get();

         if ($valeurs->count() == 0) {

            $valeurs = Valeur::where('id', $idparent_val)->first();
            $array[] = array("id" => $valeurs->id, "name" => $valeurs->libelle);
        } else {
            foreach ($valeurs as $valeur) {
                $array[] = array("id" => $valeur->id, "name" => $valeur->libelle);
            }
        }
        //dd($array);
        return json_encode($array);
    }
    public function listevakeur(Request $request)
    {
      $parent=$request->idparent_val;
      $array[]='';
         $valeurs = Valeur::where('parametre_id',  $parent)->get();

                foreach ($valeurs as $valeur)
                    {
                        $array[] = array("id" => $valeur->id, "libelle" => $valeur->libelle, "val_id" => $valeur->val_id, "description" => $valeur->description);
                    }

                 return json_encode($array) ;

    }
}
