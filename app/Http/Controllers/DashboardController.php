<?php

namespace App\Http\Controllers;

use App\Models\Formulaire;
use App\Models\Recette;
use App\Models\RecetteQuittance;
use App\Models\Registre;
use App\Models\Tache;
use App\Models\Testlin;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public $startOfYear;

    public $endOfYear;

    public function dash_principal(Request $request)
    {
        $tache_encours = Tache::whereIn('statut', [env('ID_STATUT_NON_DEMARRE'), env('ID_STATUT_ENCOURS')])->where('creer_par', Auth::user()->id)->orderBy('deadline', 'asc')->get();
        $mes_taches_encours = Tache::whereIn('statut', [env('ID_STATUT_NON_DEMARRE', 'ID_STATUT_ENCOURS')])->where('personne_id', Auth::user()->id)->orderBy('deadline', 'asc')->get();

        $startOfYesterday = Carbon::yesterday()->startOfDay();
        $endOfYesterday = Carbon::yesterday()->endOfDay();
        // Récupérer la date du début de l'année en cours
        $today = Carbon::now();
        $startOfYear = Carbon::now()->startOfYear();
        // Récupérer la date de la fin de l'année en cours
        $endOfYear = Carbon::now()->endOfYear();
        $startOfCurrentMonth = Carbon::now()->startOfMonth();
        $endOfCurrentMonth = Carbon::now()->endOfMonth();

        $startOfLastMonth = Carbon::now()->subMonth()->startOfMonth();
        $endOfLastMonth = Carbon::now()->subMonth()->endOfMonth();
        // Récupérer les recettes dont la date de création est comprise entre le début et la fin de l'année
        $recette_de_lannee_encours = Recette::whereBetween('date_saisie', [$startOfYear, $endOfYear])->where('statut', 1)->get();

        $nombre_de_formulaire_emis = Formulaire::whereBetween('date_fourniture', [$startOfYear, $endOfYear])->get();
        $nombre_de_formulaire_traite_par_la_recettes = RecetteQuittance::whereBetween('date_siege', [$startOfYear, $endOfYear])->get();
        $nombre_de_carte_produits = Registre::where('entite_id', env('ID_SERVICE_PRODUCTION'))->whereBetween('date_effet', [$startOfYear, $endOfYear])->get();
        $nombre_de_passport_produits = Registre::where('entite_id', env('ID_SERVICE_PASSEPORT'))->whereBetween('date_effet', [$startOfYear, $endOfYear])->get();
        $statistique_cnib_du_mois_en_cours = Registre::where('entite_id', env('ID_SERVICE_PRODUCTION'))->whereBetween('date_effet', [$startOfCurrentMonth, $endOfCurrentMonth])->get();

        $mouvement_teslins_entrees = Testlin::where('type_operation', 'entree')->get();
        $mouvement_teslins_sorties = Testlin::where('type_operation', 'sortie')->get();
        $mouvement_teslins_retours = Testlin::where('type_operation', 'retour')->get();
        $stock_theorique = $mouvement_teslins_entrees->sum('quantite') + $mouvement_teslins_retours->sum('quantite') - $mouvement_teslins_sorties->sum('quantite');
        ///dd($stock_theorique);
        if (return_role_adequat(env('ID_MANAGER_GENERAL_ROLE'))) {
            if ($request->detail == 'carte_imprime') {
                return view('backend.dashboard_detail_cnib', compact('stock_theorique', 'statistique_cnib_du_mois_en_cours', 'nombre_de_carte_produits', 'tache_encours', 'recette_de_lannee_encours', 'tache_encours', 'nombre_de_formulaire_traite_par_la_recettes', 'nombre_de_formulaire_emis', 'recette_de_lannee_encours'));

            } elseif ($request->detail == 'recette') {
                return view('backend.dashboard_detail_recette', compact('stock_theorique', 'statistique_cnib_du_mois_en_cours', 'nombre_de_carte_produits', 'tache_encours', 'recette_de_lannee_encours', 'tache_encours', 'nombre_de_formulaire_traite_par_la_recettes', 'nombre_de_formulaire_emis', 'recette_de_lannee_encours'));
            } elseif ($request->detail == 'formulaire_emise') {
                return view('backend.dashboard_formulaire_emis', compact('stock_theorique', 'statistique_cnib_du_mois_en_cours', 'nombre_de_carte_produits', 'tache_encours', 'recette_de_lannee_encours', 'tache_encours', 'nombre_de_formulaire_traite_par_la_recettes', 'nombre_de_formulaire_emis', 'recette_de_lannee_encours'));
            } elseif ($request->detail == 'tache') {
                return view('backend.dashboard_sec', compact('stock_theorique', 'statistique_cnib_du_mois_en_cours', 'nombre_de_carte_produits', 'mes_taches_encours', 'tache_encours', 'recette_de_lannee_encours', 'tache_encours', 'nombre_de_formulaire_traite_par_la_recettes', 'nombre_de_formulaire_emis', 'recette_de_lannee_encours'));

            } elseif ($request->detail == 'testlin') {
                return view('backend.dashboard_detail_teslin', compact('stock_theorique', 'mouvement_teslins_entrees', 'mouvement_teslins_retours', 'mouvement_teslins_sorties', 'stock_theorique', 'statistique_cnib_du_mois_en_cours', 'nombre_de_carte_produits', 'tache_encours', 'recette_de_lannee_encours', 'tache_encours', 'nombre_de_formulaire_traite_par_la_recettes', 'nombre_de_formulaire_emis', 'recette_de_lannee_encours'));

            } else {
                // $nombre_de_carte_produits= Registre::where('entite_id',env('ID_SERVICE_PRODUCTION'))->whereBetween('date_effet', [$startOfYear, $endOfYear])->get();
                return view('backend.dashboard', compact('stock_theorique', 'statistique_cnib_du_mois_en_cours', 'nombre_de_passport_produits', 'nombre_de_carte_produits', 'tache_encours', 'recette_de_lannee_encours', 'tache_encours', 'nombre_de_formulaire_traite_par_la_recettes', 'nombre_de_formulaire_emis', 'recette_de_lannee_encours'));
            }
        }
        if (return_role_adequat(env('ID_MANAGER_PRODUCTION'))) {
            $nombre_de_passport_produits_hier = Registre::where('entite_id', env('ID_SERVICE_PASSEPORT'))->whereBetween('date_effet', [$startOfYesterday, $endOfYesterday])->get();
            $nombre_de_carte_produits_hier = Registre::where('entite_id', env('ID_SERVICE_PRODUCTION'))->whereBetween('date_effet', [$startOfYesterday, $endOfYesterday])->get();
            $prod_du_mois_par_antenne = DB::table('registres')
                ->leftjoin('antennes', function ($join) {
                    $join->on('registres.antenne_id', '=', 'antennes.id');
                })
                ->whereIn('registres.entite_id', [env('ID_SERVICE_PRODUCTION'), env('ID_SERVICE_PRODUCTION')])
                ->whereBetween('date_effet', [$startOfCurrentMonth, $endOfCurrentMonth])
                ->groupBy('antennes.id', 'antennes.nom_de_lantenne')
                ->select('antennes.nom_de_lantenne as antenne',
                    DB::raw('sum(registres.nbre_carte_imprime) as carte_imprime'),
                    DB::raw('sum(registres.nbre_lot_introduit) as lot_introduit'),
                    DB::raw('sum(registres.nbre_demande_saisie) as demande_saisie'),
                    DB::raw('sum(registres.nbre_carte_endomage) as carte_endomage'),
                    DB::raw('sum(registres.nbre_demande_en_instance) as demande_en_instance'),
                    DB::raw('sum(registres.nbre_carte_transmise) as carte_transmise'),

                )
                ->get();

            if ($request->detail == 'formulaire_emise') {
                return view('backend.dashboard_formulaire_emis', compact('stock_theorique', 'statistique_cnib_du_mois_en_cours', 'nombre_de_carte_produits', 'tache_encours', 'recette_de_lannee_encours', 'tache_encours', 'nombre_de_formulaire_traite_par_la_recettes', 'nombre_de_formulaire_emis', 'recette_de_lannee_encours'));

            } elseif ($request->detail == 'carte_imprime') {
                return view('backend.dashboard_detail_cnib', compact('stock_theorique', 'statistique_cnib_du_mois_en_cours', 'nombre_de_carte_produits', 'tache_encours', 'recette_de_lannee_encours', 'tache_encours', 'nombre_de_formulaire_traite_par_la_recettes', 'nombre_de_formulaire_emis', 'recette_de_lannee_encours'));

            } elseif ($request->detail == 'statistique_du_mois') {
                return view('backend.dashboard_detail_stats_of_month', compact('stock_theorique', 'prod_du_mois_par_antenne', 'statistique_cnib_du_mois_en_cours', 'nombre_de_carte_produits', 'tache_encours', 'recette_de_lannee_encours', 'tache_encours', 'nombre_de_formulaire_traite_par_la_recettes', 'nombre_de_formulaire_emis', 'recette_de_lannee_encours'));

            } else {
                return view('backend.dashboard_production', compact('stock_theorique', 'nombre_de_passport_produits_hier', 'nombre_de_carte_produits_hier', 'statistique_cnib_du_mois_en_cours', 'nombre_de_passport_produits', 'nombre_de_carte_produits', 'mes_taches_encours', 'recette_de_lannee_encours', 'tache_encours', 'nombre_de_formulaire_traite_par_la_recettes', 'nombre_de_formulaire_emis', 'recette_de_lannee_encours'));
            }
        }
        if (return_role_adequat(env('ID_ROLE_EMETTEUR_FORMULAIRE'))) {
            return redirect()->route('formulaire.etat');
        }
        if (return_role_adequat(env('ID_MANAGER_ROLE'))) {
            return view('backend.dashboard_sec', compact('nombre_de_carte_produits', 'mes_taches_encours', 'recette_de_lannee_encours', 'tache_encours', 'nombre_de_formulaire_traite_par_la_recettes', 'nombre_de_formulaire_emis', 'recette_de_lannee_encours'));
        }
        if (return_role_adequat(env('ID_ROLE_AGENT_REGISTRE'))) {
            return redirect()->route('registre.index');
        }
        if (return_role_adequat(env('ID_ROLE_CHEF_DE_SERVICE_RECETTE'))) {
            return redirect()->route('recette.synthese');
        }
        if (return_role_adequat(env('ID_ROLE_FORMULAIRE'))) {
            return redirect()->route('recette.synthese');
        }
        if (return_role_adequat(env('ID_ROLE_CHEF_DE_SERVICE_RECETTE'))) {
            return redirect()->route('recette.synthese');
        }
        if (return_role_adequat(env('ID_ROLE_AGENT_SERVICE_RECETTE'))) {
            return redirect()->route('recette.index');
        }
        if (return_role_adequat(env('ID_ROLE_ADMIN'))) {
            return redirect()->route('user.index');
        }
        if (return_role_adequat(env('ID_ROLE_RECEPTION_LOT'))) {
            return redirect()->route('recette_quittance.index');
        }
        if (return_role_adequat(env('ID_ROLE_GERER_TESLIN'))) {
            return redirect()->route('testlin.index');
        }
        //$taches_affectes=Tache::where('creer_par', Auth::user()->id)->get();
    }

    public function recette_par_antenne()
    {
        $startOfYear = Carbon::now()->startOfYear();
        // Récupérer la date de la fin de l'année en cours
        $endOfYear = Carbon::now()->endOfYear();
        $recette_par_antenne = DB::table('recettes')
            ->leftjoin('antennes', function ($join) {
                $join->on('recettes.antenne_id', '=', 'antennes.id');
            })
            ->where('recettes.statut', '!=', 0)
                            //->whereBetween('date_de_paiement', [$startOfYear, $endOfYear])
            ->groupBy('antennes.id', 'antennes.nom_de_lantenne')
            ->select('antennes.nom_de_lantenne as antenne',
                DB::raw('sum(CASE WHEN type_recette=8 THEN montant else 0 end) as dao'),
                DB::raw('sum(CASE WHEN type_recette=9 THEN montant else 0 end) as cnib'),
                DB::raw('sum(CASE WHEN type_recette=10 THEN montant else 0 end) as reversement'),
                DB::raw('sum(CASE WHEN type_recette=11 THEN montant else 0 end) as autre'))
            ->get();

        return json_encode($recette_par_antenne);
    }

    public function carte_imprime_par_antenne()
    {
        $startOfYear = Carbon::now()->startOfYear();
        // Récupérer la date de la fin de l'année en cours
        $endOfYear = Carbon::now()->endOfYear();
        $prod_cnib_par_antenne = DB::table('registres')
            ->leftjoin('antennes', function ($join) {
                $join->on('registres.antenne_id', '=', 'antennes.id');
            })
            ->whereIn('registres.entite_id', [env('ID_SERVICE_PRODUCTION'), env('ID_SERVICE_PRODUCTION')])
            ->whereBetween('date_effet', [$startOfYear, $endOfYear])
            ->groupBy('antennes.id', 'antennes.nom_de_lantenne')
            ->select('antennes.nom_de_lantenne as antenne',
                DB::raw('sum(registres.nbre_carte_imprime) as carte_imprime   '),
                DB::raw('sum(registres.nbre_carte_endomage) as carte_endomage'),
                DB::raw('sum(registres.nbre_demande_saisie) as demande_saisie'))
            ->get();

        return json_encode($prod_cnib_par_antenne);
    }

    public function formulaire_par_antenne()
    {
        $this->startOfYear = Carbon::now()->startOfYear();
        $tab_antenne = [];
        // Récupérer la date de la fin de l'année en cours
        $this->endOfYear = Carbon::now()->endOfYear();
        $formulaire_par_antenne = DB::table('centre_traitements')
            ->leftjoin('formulaire_recus', function ($join) {
                $join->on('formulaire_recus.centre_traitement_id', '=', 'centre_traitements.id');
            })
            ->leftjoin('antennes', function ($join) {
                $join->on('centre_traitements.antenne_id', '=', 'antennes.id');
            })
                            //->join('antennes','centre_traitements.antenne_id','=','antennes.id')
            ->whereBetween('formulaire_recus.created_at', [$this->startOfYear, $this->endOfYear])
            ->groupBy('antennes.id')
            ->select('antennes.nom_de_lantenne as antenne',
                'antennes.id as antenne_id',
                // DB::raw("sum(formulaires.nombre) as nb_form_emis   "),
                DB::raw('sum(formulaire_recus.nbre_formulaire) as formulaire_recu'),
                DB::raw('sum(formulaire_recus.nbre_carte_sortie) as carte_sortie'))
            ->get();
        // dd($formulaire_par_antenne);
        $formulaire_emis_par_antenne = DB::table('centre_traitements')
            ->leftjoin('formulaires', function ($join) {
                $join->on('formulaires.centre_traitement_id', '=', 'centre_traitements.id')
                    ->where('formulaires.centre_traitement_id', '!=', null)
                    ->whereBetween('formulaires.date_fourniture', [$this->startOfYear, $this->endOfYear]);
            })
            ->leftjoin('antennes', function ($join) {
                $join->on('centre_traitements.antenne_id', '=', 'antennes.id');
            })
                            //->join('antennes','centre_traitements.antenne_id','=','antennes.id')
           // ->whereBetween('formulaires.created_at', [$startOfYear, $endOfYear])
            ->groupBy('antennes.id')
            ->select('antennes.nom_de_lantenne as antenne',
                'antennes.id as antenne_id',
                DB::raw('sum(formulaires.nombre) as nb_form_emis'),
            )
            ->get();

        // dd($formulaire_emis_par_antenne);
        foreach ($formulaire_emis_par_antenne as $antenne) {
            $form_emis = $formulaire_emis_par_antenne->where('antenne_id', $antenne->antenne_id)->first()->nb_form_emis;
            if ($formulaire_par_antenne->where('antenne_id', $antenne->antenne_id)->first()) {
                $form_recus = $formulaire_par_antenne->where('antenne_id', $antenne->antenne_id)->first()->formulaire_recu;
                $carte_sortie = $formulaire_par_antenne->where('antenne_id', $antenne->antenne_id)->first()->carte_sortie;
            } else {
                $form_recus = 0;
                $carte_sortie = 0;
            }
            $ligne = [
                'antenne' => $antenne->antenne,
                'formulaire_emis' => $antenne->nb_form_emis,
                'formulaire_recu_prod' => $form_recus,
                'carte_sortie' => $carte_sortie,
                'formulaire_restants' => $antenne->nb_form_emis - $form_recus,
            ];
            $tab_antenne[] = $ligne;
        }

        return json_encode($tab_antenne);
    }
}
