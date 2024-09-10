<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Recette;
use App\Models\Tache;
use App\Models\Formulaire;
use App\Models\RecetteQuittance;
use App\Models\Taches;
use App\Models\Registre;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
class DashboardController extends Controller
{
   public function dash_principal( Request $request){
        $tache_encours= Tache::whereIn('statut',[env('ID_STATUT_NON_DEMARRE'),env('ID_STATUT_ENCOURS')])->where('creer_par',Auth::user()->id)->orderBy('deadline','asc')->get();
        $mes_taches_encours= Tache::whereIn('statut',[env('ID_STATUT_NON_DEMARRE','ID_STATUT_ENCOURS')])->where('personne_id',Auth::user()->id)->orderBy('deadline','asc')->get();

         // Récupérer la date du début de l'année en cours
         $startOfYear = Carbon::now()->startOfYear();
         // Récupérer la date de la fin de l'année en cours
         $endOfYear = Carbon::now()->endOfYear();
         // Récupérer les recettes dont la date de création est comprise entre le début et la fin de l'année
        $recette_de_lannee_encours = Recette::whereBetween('date_saisie', [$startOfYear, $endOfYear])->where('statut',1)->get();

        $nombre_de_formulaire_emis= Formulaire::whereBetween('date_fourniture', [$startOfYear, $endOfYear])->get();
        $nombre_de_formulaire_traite_par_la_recettes= RecetteQuittance::whereBetween('date_siege', [$startOfYear, $endOfYear])->get();
        $nombre_de_carte_produits= Registre::where('entite_id',env('ID_SERVICE_PRODUCTION'))->whereBetween('date_effet', [$startOfYear, $endOfYear])->get();

        if(return_role_adequat(env('ID_MANAGER_GENERAL_ROLE'))){
            if($request->detail=='carte_imprime'){
                return view('backend.dashboard_detail_cnib', compact('nombre_de_carte_produits','tache_encours','recette_de_lannee_encours','tache_encours','nombre_de_formulaire_traite_par_la_recettes','nombre_de_formulaire_emis','recette_de_lannee_encours'));

            }
            elseif($request->detail=='recette'){
                return view('backend.dashboard_detail_recette', compact('nombre_de_carte_produits','tache_encours','recette_de_lannee_encours','tache_encours','nombre_de_formulaire_traite_par_la_recettes','nombre_de_formulaire_emis','recette_de_lannee_encours'));
            }
            elseif($request->detail=='formulaire_emise'){
                return view('backend.dashboard_formulaire_emis', compact('nombre_de_carte_produits','tache_encours','recette_de_lannee_encours','tache_encours','nombre_de_formulaire_traite_par_la_recettes','nombre_de_formulaire_emis','recette_de_lannee_encours'));

            }
            elseif($request->detail=='tache'){
                return view('backend.dashboard_sec', compact('nombre_de_carte_produits','mes_taches_encours','tache_encours','recette_de_lannee_encours','tache_encours','nombre_de_formulaire_traite_par_la_recettes','nombre_de_formulaire_emis','recette_de_lannee_encours'));

            }
            else{
                $nombre_de_passport_produits= Registre::where('entite_id',env('ID_SERVICE_PASSEPORT'))->whereBetween('date_effet', [$startOfYear, $endOfYear])->get();
               // $nombre_de_carte_produits= Registre::where('entite_id',env('ID_SERVICE_PRODUCTION'))->whereBetween('date_effet', [$startOfYear, $endOfYear])->get();
                return view('backend.dashboard', compact('nombre_de_passport_produits','nombre_de_carte_produits','tache_encours','recette_de_lannee_encours','tache_encours','nombre_de_formulaire_traite_par_la_recettes','nombre_de_formulaire_emis','recette_de_lannee_encours'));
            }
        }
        if(return_role_adequat(env('ID_MANAGER_ROLE'))){
            return view('backend.dashboard_sec', compact('nombre_de_carte_produits','mes_taches_encours','recette_de_lannee_encours','tache_encours','nombre_de_formulaire_traite_par_la_recettes','nombre_de_formulaire_emis','recette_de_lannee_encours'));
        }
        //$taches_affectes=Tache::where('creer_par', Auth::user()->id)->get();
   }
   public function recette_par_antenne(){
                $startOfYear = Carbon::now()->startOfYear();
                // Récupérer la date de la fin de l'année en cours
                $endOfYear = Carbon::now()->endOfYear();
                $recette_par_antenne = DB::table('recettes')
                                    ->leftjoin('antennes',function($join){
                                        $join->on('recettes.antenne_id','=','antennes.id');
                                    })
                                     ->where('recettes.statut','!=',0)
                                    //->whereBetween('date_de_paiement', [$startOfYear, $endOfYear])
                                    ->groupBy('antennes.id','antennes.nom_de_lantenne')
                                    ->select('antennes.nom_de_lantenne as antenne',
                                            DB::raw("sum(CASE WHEN type_recette=8 THEN montant else 0 end) as dao"),
                                            DB::raw("sum(CASE WHEN type_recette=9 THEN montant else 0 end) as cnib"),
                                            DB::raw("sum(CASE WHEN type_recette=10 THEN montant else 0 end) as reversement"),
                                            DB::raw("sum(CASE WHEN type_recette=11 THEN montant else 0 end) as autre"))
                                    ->get();
            return json_encode($recette_par_antenne);
   }
   public function carte_imprime_par_antenne(){
    $startOfYear = Carbon::now()->startOfYear();
    // Récupérer la date de la fin de l'année en cours
    $endOfYear = Carbon::now()->endOfYear();
    $prod_cnib_par_antenne = DB::table('registres')
                        ->leftjoin('antennes',function($join){
                            $join->on('registres.antenne_id','=','antennes.id');
                        })
                        ->whereIn('registres.entite_id',[env('ID_SERVICE_PRODUCTION'),env('ID_SERVICE_PRODUCTION')])
                        ->whereBetween('date_effet', [$startOfYear, $endOfYear])
                        ->groupBy('antennes.id','antennes.nom_de_lantenne')
                        ->select('antennes.nom_de_lantenne as antenne',
                                DB::raw("sum(registres.nbre_carte_imprime) as carte_imprime   "),
                                DB::raw("sum(registres.nbre_carte_endomage) as carte_endomage"),
                                DB::raw("sum(registres.nbre_demande_saisie) as demande_saisie"))
                        ->get();
        return json_encode($prod_cnib_par_antenne);
}
public function formulaire_par_antenne(){
    $startOfYear = Carbon::now()->startOfYear();
    $tab_antenne=[];
    // Récupérer la date de la fin de l'année en cours
    $endOfYear = Carbon::now()->endOfYear();
    $formulaire_par_antenne = DB::table('centre_traitements')
                        ->leftjoin ('formulaire_recus',function($join){
                            $join->on('formulaire_recus.centre_traitement_id','=','centre_traitements.id');
                        })
                        ->leftjoin('antennes',function($join){
                            $join->on('centre_traitements.antenne_id','=','antennes.id');
                        })
                        //->join('antennes','centre_traitements.antenne_id','=','antennes.id')
                        ->whereBetween('formulaire_recus.created_at', [$startOfYear, $endOfYear])
                        ->groupBy('antennes.id')
                        ->select('antennes.nom_de_lantenne as antenne',
                                'antennes.id as antenne_id',
                               // DB::raw("sum(formulaires.nombre) as nb_form_emis   "),
                                DB::raw("sum(formulaire_recus.nbre_formulaire) as formulaire_recu"),
                                DB::raw("sum(formulaire_recus.nbre_carte_sortie) as carte_sortie"))
                        ->get();
           // dd($formulaire_par_antenne);
    $formulaire_emis_par_antenne = DB::table('centre_traitements')
                        ->leftjoin('formulaires',function($join){
                            $join->on('formulaires.centre_traitement_id','=','centre_traitements.id')
                                ->where('formulaires.centre_traitement_id', '!=', null);
                            
                        })
                        ->leftjoin('antennes',function($join){
                            $join->on('centre_traitements.antenne_id','=','antennes.id');
                        })
                        //->join('antennes','centre_traitements.antenne_id','=','antennes.id')
                        ->whereBetween('formulaires.created_at', [$startOfYear, $endOfYear])
                        ->groupBy('antennes.id')
                        ->select('antennes.nom_de_lantenne as antenne',
                                'antennes.id as antenne_id',
                                 DB::raw("sum(formulaires.nombre) as nb_form_emis"),
                                )
                        ->get();
                        
       // dd($formulaire_emis_par_antenne->where('antenne_id',7)->first()->nb_form_emis);
        //$antennes= Antenne::all();
        foreach($formulaire_emis_par_antenne as $antenne){
            $form_emis=$formulaire_emis_par_antenne->where('antenne_id', $antenne->antenne_id)->first()->nb_form_emis;
            if($formulaire_par_antenne->where('antenne_id',$antenne->antenne_id)->first()){
                $form_recus=$formulaire_par_antenne->where('antenne_id',$antenne->antenne_id)->first()->formulaire_recu;
                $carte_sortie=$formulaire_par_antenne->where('antenne_id',$antenne->antenne_id)->first()->carte_sortie;
            }else{
                $form_recus= 0;
                $carte_sortie= 0;
            }
            $ligne=array(
                'antenne'=>$antenne->antenne,
                'formulaire_emis' =>$antenne->nb_form_emis,
                'formulaire_recu_prod'=> $form_recus,
                'carte_sortie'=> $carte_sortie,
             );
             $tab_antenne[]=$ligne;
        }
            //dd($tab_antenne);
        return json_encode($tab_antenne);
}
}
