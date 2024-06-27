<?php

namespace App\Http\Controllers;

use App\Models\Formulaire;
use App\Models\Antenne;
use App\Models\FormulaireRecu;
use App\Models\CentreTraitement;
use App\Models\CentreCollecte;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class FormulaireController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     public function __construct()
     {
         $this->middleware('auth');
     }
    public function index()
    {
        $formulaires=Formulaire::all();
        $antennes=Antenne::all();
        $ctids=CentreTraitement::all();
        return view('formulaire.index', compact('antennes','formulaires','ctids'));
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
       
        Formulaire::create([
            'nombre'=>$request->quantite,
            'date_fourniture'=> reformat_date($request->date_affecte),
            'date_emission'=> reformat_date($request->date_emission),
            'centre_traitement_id'=>$request->ctid,
            'premier_serie'=>$request->premier_serie,
            'dernier_serie'=>$request->dernier_serie,
            'statut'=>0,
            'user_created'=>Auth::user()->id,
            'user_updated'=>Auth::user()->id,
        ]);
        return redirect(route('formulaire_prod.index'));
    }
    public function getById(Request $request)
    {
       $formulaire=Formulaire::find($request->id);
      $data= array("centre_traitement_id" =>$formulaire->centre_traitement_id, 
                    "date_fourniture" => format_date($formulaire->date_fourniture), 
                    'date_emission' =>format_date($formulaire->date_emission), 
                    "nombre" => $formulaire->nombre,
                    "premier_serie"=>$formulaire->premier_serie,
                    "dernier_serie"=>$formulaire->dernier_serie
                );
       return json_encode($data);
    }
    public function modifier(Request $request)
    {
        $formulaire=Formulaire::find($request->formulaire_id);
        $formulaire->update([
            'nombre'=>$request->quantite,
             'centre_traitement_id'=>$request->ctid,
             'date_emission'=> reformat_date($request->date_emission),
             'date_fourniture'=>reformat_date($request->date_affecte),
             'premier_serie'=>$request->premier_serie,
             'dernier_serie'=>$request->dernier_serie,
             'nombre'=>$request->quantite,
             ]);
             return redirect( route('formulaire_prod.index'));
    }
    /**
     * Display the specified resource.
     */
    public function show(Formulaire $formulaire)
    {
       
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Formulaire $formulaire)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Formulaire $formulaire)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Formulaire $formulaire)
    {
        //
    }
    public function liste_save_formulaire_recus()
    {
        //flash('My message');
        $formulaires=FormulaireRecu::all();
        if(Auth::user()->antenne_id==100){
            //$antennes=Antenne::all();
            $ctids=CentreTraitement::all();
        }else{
            $antenne=Antenne::find(Auth::user()->antenne_id);
            $ctids=CentreTraitement::where('antenne_id',$antenne->id)->get();
        }
        //$ccds=CentreCollecte::all();
        return view('formulaire.saisie-reception', compact('formulaires','ctids'));
    }
    public function save_formulaire_recus(Request $request)
    {
       $ccd=CentreCollecte::find($request->ccd);
        FormulaireRecu::create([
            'nbre_formulaire'=>$request->nombre_formulaire,
            'centre_traitement_id'=>$ccd->ctid->id,
            'centre_collecte_id'=>$request->ccd,
            'numero_lot'=>$request->numero_lot,
            'premier_serie'=>$request->premier_serie,
            'dernier_serie'=>$request->dernier_serie,
            'statut'=>0,
            'user_created'=>Auth::user()->id,
            'user_updated'=>Auth::user()->id,
        ]);
        return redirect(route('formulaire_recu.liste'))->with('success','Lot enregistré avec success!');
    }
    public function getFormulaire_recusById(Request $request)
    {
        $formulaire=FormulaireRecu::find($request->id);
        $data= array("numero_lot" =>$formulaire->numero_lot,"centre_traitement_id" =>$formulaire->centre_traitement_id,"centre_collecte_id" =>$formulaire->centre_collecte_id, "centre_collecte_libelle" =>$formulaire->ccd->libelle, "date_fourniture" => format_date($formulaire->date_fourniture), 'date_emission' =>format_date($formulaire->date_emission), "nombre" => $formulaire->nbre_formulaire, "premier_serie"=>$formulaire->premier_serie,"dernier_serie"=>$formulaire->dernier_serie);
       return json_encode($data);
    }
    public function modifier_formulaire_recus(Request $request)
    {
        $ccd=CentreCollecte::find($request->ccd);
        $formulaire=FormulaireRecu::find($request->formulaire_recu);
        $formulaire->update([
            'nbre_formulaire'=>$request->nombre_formulaire,
            'centre_traitement_id'=>$ccd->ctid->id,
            'centre_collecte_id'=>$request->ccd,
            'numero_lot'=>$request->numero_lot,
            'premier_serie'=>$request->premier_serie,
            'dernier_serie'=>$request->dernier_serie,
        ]);
             return redirect( route('formulaire_recu.liste'))->with('success','Lot modifié avec success!');
    }
    public function verifier_saisie(Request $request)
        {
            $nbre_de_formulaire_renseigne = $request->nbre_formulaire;
            $ccd=CentreCollecte::find($request->ccd);
            $ctid=$ccd->CTID;
            $formulaire_affectes_aux_ctid= $ctid->formulaires->sum('nombre');
            $nombre_de_quittance_saisie_ccd_du_ctid= $ctid->recette_quittances->sum('nbre_formulaire');
            //dd($nombre_de_quittance_saisie_ccd_du_ctid);
            if($request->type_operation=='creation'){
               $nbre_formulaire_restant_au_ctid= $formulaire_affectes_aux_ctid - $nombre_de_quittance_saisie_ccd_du_ctid;
            }
            else{
                $formulaire=FormulaireRecu::find($request->element_modified);
                   
                $nbre_formulaire_restant_au_ctid= $formulaire_affectes_aux_ctid + $formulaire->nbre_formulaire - $nombre_de_quittance_saisie_ccd_du_ctid;
            }

                return $result=$nbre_formulaire_restant_au_ctid - $nbre_de_formulaire_renseigne;

        }
}
