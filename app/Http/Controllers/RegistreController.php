<?php

namespace App\Http\Controllers;

use App\Models\Registre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegistreController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       if(Auth::user()->antenne_id == 100 ){
            if(Auth::user()->entite_id !=null){
                $registres= Registre::where('entite_id', Auth::user()->entite_id)->get();
            }
            else{
                $registres= Registre::all();
            }
       }else{
            if(Auth::user()->entite_id){
                $registres= Registre::where('antenne_id', Auth::user()->antenne_id )->where('entite_id', Auth::user()->entite_id)->get();
            }
        else{
            $registres= Registre::where('antenne_id', Auth::user()->antenne_id)->get();
        }
       }
       
       if(Auth::user()->entite_id== env('ID_SERVICE_PRODUCTION')){
            return view('registre.production',compact('registres'));
       }
       if(Auth::user()->entite_id== env('ID_SECTION_TRI')){
        return view('registre.tri',compact('registres'));
        }
        if(Auth::user()->entite_id== env('ID_SERVICE_BIOMETRIE')){
            return view('registre.biometrie',compact('registres'));
       }
       if(Auth::user()->entite_id== env('ID_SERVICE_RECEPTION')){
        return view('registre.reception',compact('registres'));
    }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Registre::create([
            'effectif_theorique'=>$request->eff_theorique,
            'effectif_present'=>$request->eff_present,
            'effectif_absent'=>$request->eff_absent,
            'effectif_conge'=>$request->eff_conge,
            'effectif_mission'=>$request->eff_mission,
            'effectif_malade'=>$request->eff_maladie,
            'effectif_permission'=>$request->eff_permission,
            'nbre_lot_introduit'=>$request->nbre_lot_introduit,
            'nbre_demande_saisie'=>$request->nbre_demande_saisie,
            'nbre_demande_supervise'=>$request->nbre_demande_supervise,
            'nbre_carte_imprime'=>$request->nbre_carte_imprime,
            'nbre_carte_assure'=>$request->nrbre_carte_assure,
            'nbre_carte_endomage'=>$request->nbre_carte_endomage,

            'nbre_photos_a_verifier'=>$request->nbre_photos_a_verifier,
            'nbre_photo_enrole_manuellement'=>$request->nbre_photo_enrole_manuellement,
            'nbre_photo_triees'=>$request->nbre_photo_triees,
            'nbre_photo_investigues'=>$request->nbre_photo_investigues,
            'nbre_photo_en_attente_de_tirage'=>$request->nbre_photo_en_attente_de_tirage,
            'nbre_photo_en_attente_dinvestigation'=>$request->nbre_photo_en_attente_dinvestigation,
            'nbre_photo_cas_fraude'=>$request->nbre_photo_cas_fraude,
            
            'date_effet'=>reformat_date($request->date_effet),
            'statut'=>0,
            'entite_id'=>Auth::user()->entite_id,
            'antenne_id'=>Auth::user()->antenne_id,
            'creer_par'=>Auth::user()->id,
            'modifier_par'=>Auth::user()->id,
        ]);
        return redirect()->route('registre.index')->with('success','Registre enregistré avec success !!');
    }
    public function getById(Request $request)
    {
       $registre=Registre::find($request->id);
       return json_encode($registre);
    }
    public function modifier(Request $request)
    {
        //dd($request->registre_id);
        $registre=Registre::find($request->registre_id);
        $registre->update([
            'effectif_theorique'=>$request->eff_theorique,
            'effectif_present'=>$request->eff_present,
            'effectif_absent'=>$request->eff_absent,
            'effectif_conge'=>$request->eff_conge,
            'effectif_mission'=>$request->eff_mission,
            'effectif_malade'=>$request->eff_maladie,
            'effectif_permission'=>$request->eff_permission,
            //champs production cnib
            'nbre_lot_introduit'=>$request->nbre_lot_introduit,
            'nbre_demande_saisie'=>$request->nbre_demande_saisie,
            'nbre_demande_supervise'=>$request->nbre_demande_supervise,
            'nbre_carte_imprime'=>$request->nbre_carte_imprime,
            'nbre_carte_assure'=>$request->nrbre_carte_assure,
            'nbre_carte_endomage'=>$request->nbre_carte_endomage,
            //champs biometrie 
            'nbre_photos_a_verifier'=>$request->nbre_photos_a_verifier,
            'nbre_photo_enrole_manuellement'=>$request->nbre_photo_enrole_manuellement,
            'nbre_photo_triees'=>$request->nbre_photo_triees,
            'nbre_photo_investigues'=>$request->nbre_photo_investigues,
            'nbre_photo_en_attente_de_tirage'=>$request->nbre_photo_en_attente_de_tirage,
            'nbre_photo_en_attente_dinvestigation'=>$request->nbre_photo_en_attente_dinvestigation,
            'nbre_photo_cas_fraude'=>$request->nbre_photo_cas_fraude,

            'date_effet'=>reformat_date($request->date_effet),
            'statut'=>0,
            'entite_id'=>Auth::user()->entite_id,
            'antenne_id'=>Auth::user()->antenne_id,
            //'creer_par'=>Auth::user()->id,
            'modifier_par'=>Auth::user()->id,
        ]);
            return redirect()->route('registre.index')->with('success','Registre modifié avec success !!');

    }
    /**
     * Display the specified resource.
     */
    public function show(Registre $registre)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Registre $registre)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Registre $registre)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Registre $registre)
    {
        //
    }
}
