<?php

namespace App\Http\Controllers;

use App\Jobs\SendEmailJob;
use App\Models\Tache;
use App\Models\User;
use App\Models\Valeur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TacheController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        if (Auth::user()->can('tache.view')) {
            $mes_taches = Tache::where('personne_id', Auth::user()->id)->whereIn('statut', [env('ID_STATUT_ENCOURS'), env('ID_STATUT_NON_DEMARRE')])->get();
            $taches_affectes = Tache::where('creer_par', Auth::user()->id)->get();
            // $taches_non_demarre=Tache::whereIn('statut',[env('ID_STATUT_NON_DEMARRE')])->where('personne_id', Auth::user()->id)->get();
            // $taches_termines=Tache::whereIn('statut',[env('ID_STATUT_TERMINE')])->where('personne_id', Auth::user()->id)->get();
            $users = User::all();
            $type_taches = Valeur::where('parametre_id', 7)->get();

            return view('tache.index', compact('mes_taches', 'taches_affectes', 'type_taches', 'users'));
        } else {
            return redirect()->back()->with('error', 'Vous ne disposer pas des droits réquis pour acceder a cette ressource !!');
        }
    }

    public function changeStatus(Request $request)
    {
        $newstatus = 0;
        $tache = Tache::find($request->id);
        if ($request->btn_val == 1) {
            if ($tache->statut == env('ID_STATUT_ENCOURS')) {
                $newstatus = env('ID_STATUT_TERMINE');
            } elseif ($tache->statut == env('ID_STATUT_NON_DEMARRE')) {
                $newstatus = env('ID_STATUT_ENCOURS');
            }

        } else {
            if ($tache->statut == env('ID_STATUT_TERMINE')) {
                $newstatus = env('ID_STATUT_ENCOURS');
            } elseif ($tache->statut == env('ID_STATUT_ENCOURS')) {
                $newstatus = env('ID_STATUT_NON_DEMARRE');
            }
        }
        $tache->update([
            'statut' => $newstatus,
        ]);

        return true;
        //return redirect()->back()->with('success','Statut de la tache modifié avec success !!');
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
        if (Auth::user()->can('tache.create')) {
            $today = today();
            $tache = Tache::create([
                'type_id' => $request->type_tache,
                'intitule' => $request->titre,
                'description' => $request->description,
                'statut' => 6680,
                'date_daffectation' => $today,
                'deadline' => reformat_date($request->date_fin),
                'personne_id' => $request->porteur,
                'creer_par' => Auth::user()->id,
            ]);
            $details = [
                'email' => $tache->porteur->email,
                'porteur' => $tache->porteur->name.' '.$tache->porteur->prenom,
                'titre_tache' => $tache->titre,
                'delais' => format_date($tache->deadline),
                'desc_tache' => $tache->description,
                'title' => "Affectation d'une nouvelle tache",
            ];

            SendEmailJob::dispatch($details);

            //flash("Role créer avec succes!!!")->error();
            return redirect(route('tache.index'));
        } else {
            //flash("Vous n'avez pas le droit d'acceder à cette resource. Veillez contacter l'administrateur!!!")->error();
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Tache $tache)
    {
        //
    }

    public function getById(Request $request)
    {
        $tache = Tache::find($request->id);

        return json_encode($tache);
    }

    public function viewById(Request $request)
    {
        $tache = Tache::find($request->id);
        $detail_tache = [
            'titre' => $tache->intitule,
            'description' => $tache->description,
            'statut' => getlibelle($tache->statut),
            'date_daffectation' => format_date($tache->date_daffectation),
            'porteur' => $tache->porteur->name.' '.$tache->porteur->prenom,
            'deadline' => format_date($tache->deadline),
        ];

        return json_encode($detail_tache);
    }

    public function modifier(Request $request)
    {
        if (Auth::user()->can('tache.create')) {
            $tache = Tache::find($request->id_tache);
            $today = today();
            $tache->update([
                'type_id' => $request->type_tache,
                'intitule' => $request->titre,
                'description' => $request->description,
                // 'statut'=>6680,
                'date_daffectation' => $today,
                'deadline' => reformat_date($request->date_fin),
                'personne_id' => $request->porteur,
            ]);
            $details = [
                'email' => $tache->porteur->email,
                'porteur' => $tache->porteur->name.' '.$tache->porteur->prenom,
                'titre_tache' => $tache->titre,
                'delais' => format_date($tache->deadline),
                'desc_tache' => $tache->description,
                'title' => "Affectation d'une nouvelle tache",
            ];

            SendEmailJob::dispatch($details);

            return redirect()->route('tache.index')->with('success', 'Tache modifiée avec success !!');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tache $tache)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tache $tache)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tache $tache)
    {
        //
    }
}
