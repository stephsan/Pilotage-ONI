<?php

namespace App\Http\Controllers;

use App\Models\Entite;
use Illuminate\Http\Request;

class EntiteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $entites=Entite::all();
        return view('entite.index', compact('entites'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Entite::create([
            'entite_id'=>$request->entite,
            'intitule'=>$request->libelle,
        ]);
       return redirect()->route('entite.index')->with('success','Entité enregistrée avec success !!');

    }
    public function getById(Request $request)
    {
        $entite=Entite::find($request->id);
       // $data= array("numero_lot" =>$formulaire->numero_lot,"centre_traitement_id" =>$formulaire->centre_traitement_id,"centre_collecte_id" =>$formulaire->centre_collecte_id, "centre_collecte_libelle" =>$formulaire->ccd->libelle, "date_fourniture" => format_date($formulaire->date_fourniture), 'date_emission' =>format_date($formulaire->date_emission), "nombre" => $formulaire->nbre_formulaire, "premier_serie"=>$formulaire->premier_serie,"dernier_serie"=>$formulaire->dernier_serie);
       return json_encode($entite);
    }
    public function modifier(Request $request)
    {
        $entite=Entite::find($request->entite_id);
        $entite->update([
             'entite_id'=>$request->entite_id,
             'intitule'=>$request->libelle,
             ]);
             return redirect( route('entite.index'))->with('success','Entité a été modifiée avec success !!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Entite $entite)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Entite $entite)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Entite $entite)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Entite $entite)
    {
        //
    }
}
