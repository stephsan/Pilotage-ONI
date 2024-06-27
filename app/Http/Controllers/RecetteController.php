<?php

namespace App\Http\Controllers;

use App\Models\Recette;
use App\Models\Valeur;
use App\Models\CentreCollecte;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use DateTime;
class RecetteController extends Controller
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
        $recettes=Recette::all();
        $ccds= CentreCollecte::all();
        $nature_recettes=Valeur::where('parametre_id',5 )->get();
        return view('recette.index', compact('recettes','ccds','nature_recettes'));
    }
public function synthese(){
        $recettes_regions= DB::table('recettes')
                                ->join('antennes',function($join){
                                $join->on('antennes.id','=','recettes.antenne_id');
                            })
                                ->join('valeurs','antennes.region_id','=','valeurs.id')
                                ->groupBy('antennes.region_id')
                                ->select("valeurs.libelle as region", 'valeurs.id as region_id', 
                                            DB::raw("sum(CASE WHEN type_recette=8 THEN montant else 0 end) as DAO"),
                                            DB::raw("sum(CASE WHEN type_recette=9 THEN montant else 0 end) as cnib"), 
                                            DB::raw("sum(CASE WHEN type_recette=10 THEN montant else 0 end) as reversement"),
                                            DB::raw("sum(CASE WHEN type_recette=11 THEN montant else 0 end) as autre"),
                                            DB::raw("sum(recettes.montant) as total"),
                                            )
                                ->get();
            $recettes_par_mois= DB::table('recettes')
                ->select(
                            DB::raw("sum(CASE WHEN type_recette=8 THEN montant else 0 end) as DAO"),
                            DB::raw("sum(CASE WHEN type_recette=9 THEN montant else 0 end) as cnib"), 
                            DB::raw("sum(CASE WHEN type_recette=10 THEN montant else 0 end) as reversement"),
                            DB::raw("sum(CASE WHEN type_recette=11 THEN montant else 0 end) as autre"),
                            DB::raw("sum(recettes.montant) as total"),
                            DB::raw('MONTH(recettes.date_saisie) month')
                            )
                ->groupby('month')
                ->orderBy('recettes.date_saisie','asc')
                ->get();
                return view('recette.synthese', compact('recettes_par_mois','recettes_regions'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
       
    }
    public function getById(Request $request)
    {
       // $data=[];
       $recette=Recette::find($request->id);
       return json_encode($recette);
    }
    public function modifier(Request $request)
    {
        $recette=Recette::find($request->recette_id);
        $recette->update([
            'numero'=>$request->numero,
            'type_recette'=>$request->nature,
            'montant'=>$request->montant,
            'observation'=>$request->observation,
            'site_operation'=>$request->site,
            'motif'=>$request->motif,
            'date_de_paiement'=>$request->date_de_paiement,
            'nom_complet_dela_personne'=>$request->denomination,
        ]);
             return redirect( route('recette.index'));
    }
    public function valider( Request $request ){
            foreach($request->recettes as $recette_id){
                $recette=Recette::find($recette_id);
                $recette->update([
                    "statut"=>1
                ]);
            }
            return redirect()->back();
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $today = today(); 
        if(Auth::user()->antenne_id==100){
            $antenne=env('antenne_centre_id');
        }else{
            $antenne=Auth::user()->antenne_id;
        }
       Recette::create([
            'date_saisie'=>$today,
            'type_recette'=>$request->nature,
            'montant'=>$request->montant,
            'motif'=>$request->motif,
            'date_de_paiement'=>$request->date_de_paiement,
            'nom_complet_dela_personne'=>$request->denomination,
            'observation'=>$request->observation,
            'site_operation'=>$request->site,
            'antenne_id'=>$antenne,
            'statut'=>0,
            'numero'=>1,
       ]);
       return redirect()->route('recette.index');
    }
    /**
     * Display the specified resource.
     */
    public function show(Recette $recette)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Recette $recette)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Recette $recette)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Recette $recette)
    {
        //
    }
}
