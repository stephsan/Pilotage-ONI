<?php

namespace App\Http\Controllers;

use App\Models\Antenne;
use App\Models\Testlin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TestlinController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $antennes = Antenne::all();
        $mouvement_teslins = Testlin::all();

        return view('testlin.liste', compact('antennes', 'mouvement_teslins'));
    }

    public function getById(Request $request)
    {
        $testlin = Testlin::find($request->id);

        return json_encode($testlin);
    }

    public function modifier(Request $request)
    {
        $testlin = Testlin::find($request->testlin_id);
        $testlin->update([
            'antenne_id' => $request->antenne,
            'qte_sortie' => $request->qte_sortie,
            'qte_entree' => $request->qte_entree,
            'reference' => $request->reference,
            'date' => reformat_date($request->date),
            'modifier_par' => Auth::user()->id,
        ]);

        return redirect()->back()->with('success', 'Le mouvement du testlin a été modifiée avec success !!');
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
        Testlin::create([
            'antenne_id' => $request->antenne,
            'qte_sortie' => $request->qte_sortie,
            'qte_entree' => $request->qte_entree,
            'reference' => $request->reference,
            'date' => reformat_date($request->date),
            'creer_par' => Auth::user()->id,
        ]);

        return redirect()->back()->with('success', 'Le mouvement enregistrer avec success!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Testlin $testlin)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Testlin $testlin)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Testlin $testlin)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Testlin $testlin)
    {
        //
    }
}
