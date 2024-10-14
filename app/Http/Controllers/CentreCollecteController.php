<?php

namespace App\Http\Controllers;

use App\Models\CentreCollecte;
use App\Models\CentreTraitement;
use App\Models\Valeur;
use App\Models\Antenne;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CentreCollecteController extends Controller
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
    if (Auth::user()->can('gerer_entite')) { 
        $centres = CentreCollecte::all();
        $ctids = CentreTraitement::all();
        $antennes=Antenne::all();
        $provinces=Valeur::where('parametre_id',2 )->get();
        $communes=Valeur::where('parametre_id',3 )->get();
        return view('centreCollecte.index', compact('ctids','centres','antennes','provinces','communes'));
        }
        else{
            return redirect()->back()->with('error',"Vous n'avez pas la permission pour effectuer cette action!");
        }
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
    if (Auth::user()->can('gerer_entite')) { 
        $ctid= CentreTraitement::find($request->ctid);
        $lastOne = DB::table('centre_collectes')->latest('id')->first();
        if($lastOne){
        $code_centre="CCD-00". $lastOne->id+1;}
        else{
            $code_centre="CCD-00".'0';
        }
        CentreCollecte::create([
            'code'=>$code_centre,
             'region_id'=>$ctid->region_id,
             'province_id'=>$ctid->province_id,
             'commune_id'=>$request->commune,
             'libelle'=>$request->libelle,
             'centre_traitement_id'=>$request->ctid,
             'description'=>$request->description,
             ]);
             return redirect( route('centreCollecte.index'));
            }
            else{
                return redirect()->back()->with('error',"Vous n'avez pas la permission pour effectuer cette action!");
            }
    }

    public function modifier(Request $request)
    {
        if (Auth::user()->can('gerer_entite')) { 
        $ctid= CentreTraitement::find($request->ctid);
        $centre=CentreCollecte::find($request->centre_id);
        $centre->update([
             'region_id'=>$ctid->region_id,
             'province_id'=>$ctid->province_id,
             'commune_id'=>$request->commune,
             'libelle'=>$request->libelle,
             'centre_traitement_id'=>$request->ctid,
             'description'=>$request->description,
             ]);
             return redirect( route('centreCollecte.index'));
            }
            else{
                return redirect()->back()->with('error',"Vous n'avez pas la permission pour effectuer cette action!");
            }
    }

    /**
     * Display the specified resource.
     */
    public function show(CentreCollecte $centreCollecte)
    {
        //
    }
    public function getById(Request $request)
    {
       $centre=CentreCollecte::find($request->id);
       $test= array('antenne'=>$centre->ctid->antenne_id, 'ctid'=>$centre->centre_traitement_id,'commune'=>$centre->commune_id, 'libelle'=>$centre->libelle, 'description'=>$centre->description);
       return json_encode($test);
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CentreCollecte $centreCollecte)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CentreCollecte $centreCollecte)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CentreCollecte $centreCollecte)
    {
        //
    }
}
