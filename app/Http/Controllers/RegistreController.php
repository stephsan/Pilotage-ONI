<?php

namespace App\Http\Controllers;

use App\Models\Registre;
use App\Models\RegistreAbsent;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RegistreController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    private $date_search;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        if (Auth::user()->antenne_id == 100) {
            if (Auth::user()->entite_id != null) {
                $registres = Registre::where('entite_id', Auth::user()->entite_id)->get();
            } else {
                $registres = Registre::all();
            }
        } else {
            if (Auth::user()->entite_id) {
                $registres = Registre::where('antenne_id', Auth::user()->antenne_id)->where('entite_id', Auth::user()->entite_id)->get();
            } else {
                $registres = Registre::where('antenne_id', Auth::user()->antenne_id)->get();
            }
        }

        if (Auth::user()->entite_id == env('ID_SERVICE_PRODUCTION')) {
            return view('registre.production', compact('registres', 'users'));
        }
        if (Auth::user()->entite_id == env('ID_SECTION_TRI')) {
            return view('registre.tri', compact('registres', 'users'));
        }
        if (Auth::user()->entite_id == env('ID_SERVICE_BIOMETRIE')) {
            return view('registre.biometrie', compact('registres', 'users'));
        }
        if (Auth::user()->entite_id == env('ID_SERVICE_RECEPTION')) {
            return view('registre.reception', compact('registres', 'users'));
        }
        if (Auth::user()->entite_id == env('ID_SERVICE_VIP')) {
            return view('registre.vip', compact('registres', 'users'));
        }
        if (Auth::user()->entite_id == env('ID_SERVICE_PASSEPORT')) {
            return view('registre.passport', compact('registres', 'users'));
        }
        if (Auth::user()->entite_id == env('ID_SERVICE_ENQUETE')) {
            return view('registre.enquete', compact('registres', 'users'));
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

        //dd($request->absents);
        $registre = Registre::create([
            'effectif_theorique' => $request->eff_theorique,
            'effectif_present' => $request->eff_present,
            'effectif_absent' => count($request->absents),
            'effectif_conge' => $request->eff_conge,
            'effectif_mission' => $request->eff_mission,
            'effectif_malade' => $request->eff_maladie,
            'effectif_permission' => $request->eff_permission,
            'nbre_lot_introduit' => $request->nbre_lot_introduit,
            'nbre_demande_saisie' => $request->nbre_demande_saisie,
            'nbre_demande_supervise' => $request->nbre_demande_supervise,
            'nbre_carte_imprime' => $request->nbre_carte_imprime,
            'nbre_carte_assure' => $request->nrbre_carte_assure,
            'nbre_carte_endomage' => $request->nbre_carte_endomage,

            'nbre_photos_a_verifier' => $request->nbre_photos_a_verifier,
            'nbre_photo_enrole_manuellement' => $request->nbre_photo_enrole_manuellement,
            'nbre_photo_triees' => $request->nbre_photo_triees,
            'nbre_photo_investigues' => $request->nbre_photo_investigues,
            'nbre_photo_en_attente_de_tirage' => $request->nbre_photo_en_attente_de_tirage,
            'nbre_photo_en_attente_dinvestigation' => $request->nbre_photo_en_attente_dinvestigation,
            'nbre_photo_cas_fraude' => $request->nbre_photo_cas_fraude,

            'nbre_de_carte_disponible' => $request->nbre_de_carte_disponible,
            'nbre_de_carte_restitue' => $request->nbre_de_carte_restitue,
            'nbre_de_carte_recus' => $request->nbre_de_carte_recus,

            'nbre_demande_saisie' => $request->nbre_demande_saisie,
            'nbre_lot_introduit' => $request->nbre_lot_introduit,

            'observation' => $request->observation,
            'nbre_demande_en_instance' => $request->nbre_demande_en_instance,
            'nbre_carte_transmise' => $request->nbre_carte_transmise,
            'stock_de_teslin' => $request->stock_de_teslin,
            'stock_de_tamine_imprime' => $request->stock_de_tamine_imprime,
            'stock_de_tamine_vierge' => $request->stock_de_tamine_vierge,

            'nbre_passport_ordi_produit' => $request->nbre_passport_ordi_produit,
            'nbre_passport_ordinaire_rejete' => $request->nbre_passport_ordinaire_rejete,
            'nbre_dossier_transmis' => $request->nbre_dossier_transmis,
            'nbre_dossier_rejete' => $request->nbre_dossier_rejete,
            'nbre_dossier_en_instance' => $request->nbre_dossier_en_instance,

            'nbre_dossier_recu' => $request->nbre_dossier_recu,
            'nbre_dossier_traite' => $request->nbre_dossier_traite,
            'nbre_passport_ord_faute' => $request->nbre_passport_ord_faute,
            'nbre_passport_ord_vierge_restant' => $request->nbre_passport_ord_vierge_restant,
            'nbre_passport_refugie_produit' => $request->nbre_passport_refugie_produit,

            'date_effet' => reformat_date($request->date_effet),
            'statut' => 0,
            'entite_id' => Auth::user()->entite_id,
            'antenne_id' => Auth::user()->antenne_id,
            'creer_par' => Auth::user()->id,
            'modifier_par' => Auth::user()->id,
        ]);
        foreach ($request->absents as $absent) {
            RegistreAbsent::create([
                'registre_id' => $registre->id,
                'user_id' => $absent,
            ]);
        }

        return redirect()->route('registre.index')->with('success', 'Registre enregistré avec success !!');
    }

    public function rapport_journalier(Request $request)
    {
        $today = Carbon::now();
        // $date = '2024-07-02';
        // $date = strtotime($dateString);
        $rapport_productions = DB::table('registres')
            ->join('antennes', function ($join) {
                $join->on('registres.antenne_id', '=', 'antennes.id');
                //->where(DB::raw("DATE(date_effet) = '".date('Y-m-d')."'"));
            })
            ->whereDate('date_effet', $today)
            ->groupBy('antennes.id')
            ->select('antennes.nom_de_lantenne as antenne', DB::raw('sum(nbre_demande_saisie) as carte_emise'), DB::raw('sum(nbre_carte_endomage) as carte_detruite'), DB::raw('sum(nbre_carte_endomage) as carte_detruite'), DB::raw('sum(nbre_demande_saisie) - sum(nbre_carte_imprime) as carte_en_instance'))
            ->get();
        $rapport_reception_exception = Registre::where('entite_id', env('ID_SERVICE_RECEPTION'))->whereDate('date_effet', $today)->first();
        $rapport_passeport = Registre::where('entite_id', env('ID_SERVICE_PASSEPORT'))->whereDate('date_effet', $today)->first();
        $rapport_tri = Registre::where('entite_id', env('ID_SECTION_TRI'))->whereDate('date_effet', $today)->first();
        $rapport_biometrie = Registre::where('entite_id', env('ID_SERVICE_BIOMETRIE'))->whereDate('date_effet', $today)->first();
        $rapport_vip = Registre::where('entite_id', env('ID_SERVICE_VIP'))->whereDate('date_effet', $today)->first();
        $rapport_enquete = Registre::where('entite_id', env('ID_SERVICE_ENQUETE'))->whereDate('date_effet', $today)->first();

        //dd($rapport_reception_exceptions);

        return view('registre.rapportJounalier', compact('rapport_tri', 'rapport_biometrie', 'rapport_vip', 'rapport_enquete', 'rapport_productions', 'rapport_reception_exception', 'rapport_passeport'));
    }

    public function rapport_journalier_by_date(Request $request)
    {
        //dd($request->date_concernee);
        $date_convert_debut = strtotime($request->date_debut);
        $date_convert_fin = strtotime($request->date_fin);

        $this->date_debut = date('Y-m-d', $date_convert_debut);
        $this->date_fin = date('Y-m-d', $date_convert_fin);
        //dd($this->date_search);
        $rapport_productions = DB::table('registres')
            ->join('antennes', function ($join) {
                $join->on('registres.antenne_id', '=', 'antennes.id');
            })
            ->whereBetween('registres.date_effet', [$this->date_debut,  $this->date_fin])
            ->groupBy('antennes.id')
            ->select('antennes.nom_de_lantenne as antenne', DB::raw('sum(nbre_demande_saisie) as carte_emise'), DB::raw('sum(nbre_carte_endomage) as carte_detruite'), DB::raw('sum(nbre_carte_endomage) as carte_detruite'), DB::raw('sum(nbre_demande_saisie) - sum(nbre_carte_imprime) as carte_en_instance'))
            ->get();
        $rapport_reception_exception = Registre::where('entite_id', env('ID_SERVICE_RECEPTION'))->whereBetween('registres.date_effet', [$this->date_debut,  $this->date_fin])->first();
        $rapport_passeport = Registre::where('entite_id', env('ID_SERVICE_PASSEPORT'))->whereBetween('registres.date_effet', [$this->date_debut,  $this->date_fin])->get();
        $rapport_tri = Registre::where('entite_id', env('ID_SECTION_TRI'))->whereBetween('registres.date_effet', [$this->date_debut,  $this->date_fin])->first();
        $rapport_biometrie = Registre::where('entite_id', env('ID_SERVICE_BIOMETRIE'))->whereBetween('registres.date_effet', [$this->date_debut,  $this->date_fin])->get();
        $rapport_vip = Registre::where('entite_id', env('ID_SERVICE_VIP'))->whereBetween('registres.date_effet', [$this->date_debut,  $this->date_fin])->first();
        $rapport_enquete = Registre::where('entite_id', env('ID_SERVICE_ENQUETE'))->whereBetween('registres.date_effet', [$this->date_debut,  $this->date_fin])->first();

        return view('registre.rapportJounalier', compact('rapport_tri', 'rapport_biometrie', 'rapport_enquete', 'rapport_vip', 'rapport_productions', 'rapport_reception_exception', 'rapport_passeport'));
    }

    public function getById(Request $request)
    {
        $registre = Registre::find($request->id);

        return json_encode($registre);
    }

    public function modifier(Request $request)
    {
        //dd($request->registre_id);
        $registre = Registre::find($request->registre_id);
        $registre->update([
            'effectif_theorique' => $request->eff_theorique,
            'effectif_present' => $request->eff_present,
            'effectif_absent' => $request->eff_absent,
            'effectif_conge' => $request->eff_conge,
            'effectif_mission' => $request->eff_mission,
            'effectif_malade' => $request->eff_maladie,
            'effectif_permission' => $request->eff_permission,
            //champs production cnib
            'nbre_lot_introduit' => $request->nbre_lot_introduit,
            'nbre_demande_saisie' => $request->nbre_demande_saisie,
            'nbre_demande_supervise' => $request->nbre_demande_supervise,
            'nbre_carte_imprime' => $request->nbre_carte_imprime,
            'nbre_carte_assure' => $request->nrbre_carte_assure,
            'nbre_carte_endomage' => $request->nbre_carte_endomage,

            //champs biometrie
            'nbre_photos_a_verifier' => $request->nbre_photos_a_verifier,
            'nbre_photo_enrole_manuellement' => $request->nbre_photo_enrole_manuellement,
            'nbre_photo_triees' => $request->nbre_photo_triees,
            'nbre_photo_investigues' => $request->nbre_photo_investigues,
            'nbre_photo_en_attente_de_tirage' => $request->nbre_photo_en_attente_de_tirage,
            'nbre_photo_en_attente_dinvestigation' => $request->nbre_photo_en_attente_dinvestigation,
            'nbre_photo_cas_fraude' => $request->nbre_photo_cas_fraude,

            'nbre_de_carte_disponible' => $request->nbre_de_carte_disponible,
            'nbre_de_carte_restitue' => $request->nbre_de_carte_restitue,
            'nbre_de_carte_recus' => $request->nbre_de_carte_recus,

            'nbre_demande_saisie' => $request->nbre_demande_saisie,
            'nbre_lot_introduit' => $request->nbre_lot_introduit,
            'observation' => $request->observation,
            'nbre_demande_en_instance' => $request->nbre_demande_en_instance,
            'nbre_carte_transmise' => $request->nbre_carte_transmise,
            'stock_de_teslin' => $request->stock_de_teslin,
            'stock_de_tamine_imprime' => $request->stock_de_tamine_imprime,
            'stock_de_tamine_vierge' => $request->stock_de_tamine_vierge,

            'nbre_passport_ordi_produit' => $request->nbre_passport_ordi_produit,
            'nbre_passport_ordinaire_rejete' => $request->nbre_passport_ordinaire_rejete,
            'nbre_dossier_transmis' => $request->nbre_dossier_transmis,
            'nbre_dossier_rejete' => $request->nbre_dossier_rejete,
            'nbre_dossier_en_instance' => $request->nbre_dossier_en_instance,

            'nbre_dossier_recu' => $request->nbre_dossier_recu,
            'nbre_dossier_traite' => $request->nbre_dossier_traite,
            'nbre_passport_ord_faute' => $request->nbre_passport_ord_faute,
            'nbre_passport_ord_vierge_restant' => $request->nbre_passport_ord_vierge_restant,
            'nbre_passport_refugie_produit' => $request->nbre_passport_refugie_produit,

            'date_effet' => reformat_date($request->date_effet),
            'statut' => 0,
            'entite_id' => Auth::user()->entite_id,
            'antenne_id' => Auth::user()->antenne_id,

            'modifier_par' => Auth::user()->id,
        ]);

        return redirect()->route('registre.index')->with('success', 'Registre modifié avec success !!');

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
