<?php

namespace App\Http\Controllers;

use App\Models\CentreTraitement;
use App\Models\CentreCollecte;
use App\Models\Valeur;
use App\Models\Antenne;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class CentreTraitementController extends Controller
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
        $centres = CentreTraitement::all();
        $antennes= Antenne::all();
        $ccds = CentreCollecte::all();
        $regions=Valeur::where('parametre_id',1 )->get();
        return view('centreTraitement.index', compact('antennes','centres','regions','ccds'));
    }
    public function select_ctids_byAntenne(Request $request){
              $ctids= CentreTraitement::where('antenne_id', $request->antenne)->get();  
              //dd($ctids);
              $array[]='';
        foreach ($ctids as $ctid)
            {
                $array[] = array("id" => $ctid->id, "nom_ctid" => $ctid->libelle);
            }
            //dd($array);
         return json_encode($array) ;
    }
    public function select_commune_byCtid(Request $request){

            $elmtRechercher=$request->communeOuCtid;

            $array[]='';
            $ctid= CentreTraitement::find($request->ctid);  
            if( $elmtRechercher=='commune'){
                $datas= Valeur::where('valeur_id', $ctid->province_id)->get();  
            }
            elseif($elmtRechercher=='ccd'){
                $datas= CentreCollecte::where('centre_traitement_id', $ctid->id)->get();  
            }
            foreach ($datas as $data)
                    {
                        $array[] = array("id" => $data->id, "libelle" => $data->libelle);
                    }
           
            return json_encode($array) ;
    }
public function select_antennes_byRegionId(Request $request){
       
        $antennes= Antenne::where('region_id', $request->region)->get();  
        $array[]='';
        foreach ($antennes as $antenne)
            {
                $array[] = array("id" => $antenne->id, "libelle" => $antenne->nom_de_lantenne);
            }
        return json_encode($array) ;
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
        $lastOne = DB::table('centre_traitements')->latest('id')->first();
        if($lastOne){
        $code_centre="CTID-00". $lastOne->id+1;}
        else{
            $code_centre="CTID-00".'0';
        }
        $centre= CentreTraitement::create([
            'code'=>$code_centre,
            'antenne_id'=>$request->antenne,
             'region_id'=>$request->region,
             'province_id'=>$request->province,
             'libelle'=>$request->libelle,
             'seuil_max'=>$request->seuil_max,
             'seuil_min'=>$request->seuil_min,
             'description'=>$request->description,
        ]);
        return redirect( route('centreTraitement.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show(CentreTraitement $centreTraitement)
    {
        //
    }
    public function modifier(Request $request)
    {
        $centre=CentreTraitement::find($request->centre_id);
        $centre->update([
             'region_id'=>$request->region,
             'antenne_id'=>$request->antenne,
             'province_id'=>$request->province,
             'libelle'=>$request->libelle,
             'description'=>$request->description,
             'seuil_max'=>$request->seuil_max,
             'seuil_min'=>$request->seuil_min,
             ]);
             return redirect( route('centreTraitement.index'));
    }
    public function getById(Request $request)
    {
       $centre=CentreTraitement::find($request->id);
       return json_encode($centre);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CentreTraitement $centreTraitement)
    {
        $centre= $centreTraitement;
       // dd($centreTraitement->ccds());
        $regions=Valeur::where('parametre_id',1 )->get();
        $ccds=CentreCollecte::all();
        return view('centreTraitement.update', compact('centre','ccds','regions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CentreTraitement $centreTraitement)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CentreTraitement $centreTraitement)
    {
        //
    }
}