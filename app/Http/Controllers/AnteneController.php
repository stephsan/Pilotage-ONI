<?php

namespace App\Http\Controllers;

use App\Models\Antenne;
use App\Models\Valeur;
use Illuminate\Http\Request;

class AnteneController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
    
        $antennes=Antenne::all();
        $regions=Valeur::where('parametre_id',1 )->get();
        return view('antenne.index', compact('antennes','regions'));
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
        Antenne::create([
            'region_id'=>$request->region,
            'nom_de_lantenne'=>$request->libelle,
            'description'=>$request->description,
        ]);
        return redirect()->route('antenne.index');
    }
    public function getById(Request $request)
    {
       $antenne=Antenne::find($request->id);
       return json_encode($antenne);
    }
    public function modifier(Request $request)
    {
        $antenne=Antenne::find($request->antenne_id);
        $antenne->update([
            'region_id'=>$request->region,
            'nom_de_lantenne'=>$request->libelle,
            'description'=>$request->description,
             ]);
             return redirect( route('antenne.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Antene $antene)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Antene $antene)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Antene $antene)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Antene $antene)
    {
        //
    }
}
