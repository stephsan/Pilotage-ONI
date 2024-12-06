<?php

namespace App\Http\Controllers;

use App\Models\CentreCollecte;
use App\Models\CentreTraitement;
use App\Models\FormulaireRecu;
use App\Models\Recette;
use App\Models\RecetteQuittance;
use App\Models\Valeur;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RecetteQuittanceController extends Controller
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
        $ccds = CentreCollecte::all();
        $recette_quittances = RecetteQuittance::orderBy('updated_at', 'desc')->get();

        return view('recette_quittance.index', compact('recette_quittances', 'ccds'));
    }

    public function etat_recap()
    {
        $startOfYear = Carbon::now()->startOfYear();
        $tab_antenne = [];
        // Récupérer la date de la fin de l'année en cours
        $endOfYear = Carbon::now()->endOfYear();
        $saisie_annee_encours = DB::table('centre_traitements')
            ->join('formulaires', function ($join) {
                $join->on('formulaires.centre_traitement_id', '=', 'centre_traitements.id');
            })
            ->whereBetween('centre_traitements.created_at', [$startOfYear, $endOfYear])
            ->join('valeurs', 'centre_traitements.region_id', '=', 'valeurs.id')
            ->groupBy('valeurs.id')
            ->select('valeurs.id as region_id', 'valeurs.libelle as region')
            ->get();
        $ctids = CentreTraitement::all();
        $regions = Valeur::where('parametre_id', 1)->get();
        $formulaire_par_antenne = DB::table('centre_traitements')
            ->join('formulaire_recus', function ($join) {
                $join->on('formulaire_recus.centre_traitement_id', '=', 'centre_traitements.id');
            })
            ->leftjoin('recette_quittances', function ($join) {
                $join->on('recette_quittances.formulaire_recus_id', '=', 'formulaire_recus.id');
            })
            ->leftjoin('antennes', function ($join) {
                $join->on('centre_traitements.antenne_id', '=', 'antennes.id');
            })
                               //->join('antennes','centre_traitements.antenne_id','=','antennes.id')
            ->whereBetween('formulaire_recus.created_at', [$startOfYear, $endOfYear])
            ->groupBy('antennes.id')
            ->select('antennes.nom_de_lantenne as antenne',
                'antennes.id as antenne_id',
                DB::raw('sum(recette_quittances.nbre_formulaire) as nb_form_quittance'),
                DB::raw('sum(recette_quittances.montant) as montant'),
                DB::raw('sum(formulaire_recus.nbre_formulaire) as formulaire_recu'),
                DB::raw('sum(formulaire_recus.nbre_carte_sortie) as carte_sortie'))
            ->get();
        $formulaire_emis_par_antenne = DB::table('centre_traitements')
            ->leftjoin('formulaires', function ($join) {
                $join->on('formulaires.centre_traitement_id', '=', 'centre_traitements.id')
                    ->where('formulaires.centre_traitement_id', '!=', null);

            })
            ->leftjoin('antennes', function ($join) {
                $join->on('centre_traitements.antenne_id', '=', 'antennes.id');
            })
                                //->join('antennes','centre_traitements.antenne_id','=','antennes.id')
            ->whereBetween('formulaires.created_at', [$startOfYear, $endOfYear])
            ->groupBy('antennes.id')
            ->select('antennes.nom_de_lantenne as antenne',
                'antennes.id as antenne_id',
                DB::raw('sum(formulaires.nombre) as nb_form_emis'),
            )
            ->get();
        $tab_antenne = [];
        foreach ($formulaire_emis_par_antenne as $antenne) {
            $form_emis = $formulaire_emis_par_antenne->where('antenne_id', $antenne->antenne_id)->first()->nb_form_emis;
            if ($formulaire_par_antenne->where('antenne_id', $antenne->antenne_id)->first()) {
                $form_recus = $formulaire_par_antenne->where('antenne_id', $antenne->antenne_id)->first()->formulaire_recu;
                $nb_form_quittance = $formulaire_par_antenne->where('antenne_id', $antenne->antenne_id)->first()->nb_form_quittance;
                $montant = $formulaire_par_antenne->where('antenne_id', $antenne->antenne_id)->first()->montant;
                $carte_sortie = $formulaire_par_antenne->where('antenne_id', $antenne->antenne_id)->first()->carte_sortie;
            } else {
                $form_recus = 0;
                $carte_sortie = 0;
                $nb_form_quittance = 0;
                $montant = 0;

            }
            $ligne = [
                'antenne' => $antenne->antenne,
                'formulaire_emis' => $antenne->nb_form_emis,
                'formulaire_recu_prod' => $form_recus,
                'carte_sortie' => $carte_sortie,
                'formulaire_restants' => $antenne->nb_form_emis - $form_recus,
                'nb_form_quittance' => $nb_form_quittance,
                'montant' => $montant,
                'formulaire_restants' => $antenne->nb_form_emis - $form_recus,
            ];
            $tab_antenne[] = $ligne;
        }
        //dd($tab_antenne);

        return view('recette_quittance.recap', compact('tab_antenne', 'ctids', 'saisie_annee_encours'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    public function store(Request $request)
    {
        if (Auth::user()->can('create_quittance_recette')) {
            $today = today();
            $formulaire = FormulaireRecu::find($request->formulaire_prod);
            $quittance = RecetteQuittance::create([
                'date_siege' => reformat_date($request->date_siege),
                'numero_oni' => $request->numero_oni,
                'formulaire_recus_id' => $formulaire->id,
                'centre_traitement_id' => $formulaire->centre_traitement_id,
                'centre_collecte_id' => $formulaire->centre_collecte_id,
                'numero_tresor' => $request->numero_tresor,
                'nbre_rejet' => $request->nombre_rejet,
                'nbre_formulaire' => $formulaire->nbre_formulaire,
                'montant_formulaire' => $request->valeur_form,
                'premier_serie' => $formulaire->premier_serie,
                'dernier_serie' => $formulaire->dernier_serie,
                'statut' => 0,

                'montant' => $request->montant,
                'user_created' => Auth::user()->id,
                'user_updated' => Auth::user()->id,
            ]);
            if ($quittance) {
                Recette::create([
                    'date_saisie' => $today,
                    'type_recette' => 9,
                    'quittance_recette_ass' => $quittance->id,
                    'montant' => $request->montant,
                    'observation' => 'recette de la quittance '.$request->numero_oni,
                    'site_operation' => $formulaire->centre_collecte_id,
                    'antenne_id' => $quittance->ctid->antenne_id,
                    'statut' => 0,
                    'numero' => 1,
                ]);
            }

            return redirect()->back()->with('success', 'Lot enregistré avec success!');
        } else {
            return redirect()->back()->with('error', "Vous n'avez pas la permission pour effectuer cette action!");
        }
    }

    public function getById(Request $request)
    {
        $recette_quittance = RecetteQuittance::find($request->id);
        $data = [
            'centre_traitement_id' => $recette_quittance->centre_traitement_id,
            'centre_collecte_id' => $recette_quittance->centre_collecte_id,
            'numero_tresor' => $recette_quittance->numero_tresor,
            'nbre_rejet' => $recette_quittance->nbre_rejet,
            'numero_oni' => $recette_quittance->numero_oni,
            'date_siege' => $recette_quittance->date_siege,
            'nbre_formulaire' => $recette_quittance->nbre_formulaire,
            'montant_formulaire' => $recette_quittance->montant_formulaire,
            'montant' => $recette_quittance->montant,
            'premier_serie' => $recette_quittance->premier_serie,
            'dernier_serie' => $recette_quittance->dernier_serie,
            'ccd_libelle' => $recette_quittance->ccd->libelle,
            //"numero_lot" => $recette_quittance->lot_de_formulaire->numero_lot,
        ];

        return json_encode($data);
    }

    public function verifier_saisie(Request $request)
    {
        $nbre_de_formulaire_renseigne = $request->nbre_formulaire;
        $ccd = CentreCollecte::find($request->ccd);
        $ctid = $ccd->CTID;
        $formulaire_affectes_aux_ctid = $ctid->formulaires->sum('nombre');
        $nombre_de_quittance_saisie_ccd_du_ctid = $ctid->recette_quittances->sum('nbre_formulaire');
        if ($request->type_operation == 'creation') {
            $nbre_formulaire_restant_au_ctid = $formulaire_affectes_aux_ctid - $nombre_de_quittance_saisie_ccd_du_ctid;
        } else {
            $formulaire = nbre_formulaire::find($request->element_modified);

            $nbre_formulaire_restant_au_ctid = $formulaire_affectes_aux_ctid + $formulaire->nbre_formulaire - $nombre_de_quittance_saisie_ccd_du_ctid;
        }

        return $result = $nbre_formulaire_restant_au_ctid - $nbre_de_formulaire_renseigne;

    }

    public function details_ccd(CentreTraitement $ctid)
    {

        return view('recette_quittance.detail_recap', compact('ctid'));
    }

    public function recap_de_lannee_encours(CentreTraitement $ctid)
    {

    }

    public function modifier(Request $request)
    {
        if (Auth::user()->can('recette.create')) {
            $recetteQuittance = RecetteQuittance::find($request->quittance_id);
            $recetteQuittance->update([
                'date_siege' => $request->date_siege,
                'numero_oni' => $request->numero_oni,
                'montant_formulaire' => $request->valeur_form,
                'nbre_rejet' => $request->nombre_rejet,
                'numero_tresor' => $request->numero_tresor,
                'montant' => $request->montant,
                'nbre_formulaire' => $request->nombre_formulaire,
                'user_updated' => Auth::user()->id,
            ]);

            $recette = Recette::where('quittance_recette_ass', $recetteQuittance->id)->first();
            $recette->update([
                'montant' => $request->montant,
            ]);

            return redirect(route('recette_quittance.index'));
        } else {
            return redirect()->back()->with('error', "Vous n'avez pas la permission pour effectuer cette action!");
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(RecetteQuittance $recetteQuittance)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RecetteQuittance $recetteQuittance)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, RecetteQuittance $recetteQuittance)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RecetteQuittance $recetteQuittance)
    {
        //
    }
}
