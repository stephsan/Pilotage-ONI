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
        if (Auth::user()->can('gerer_teslin')) {
            $antennes = Antenne::all();
            $mouvement_teslins = Testlin::all();
            $mouvement_teslins_entrees = Testlin::where('type_operation', 'entree')->get();
            $mouvement_teslins_sorties = Testlin::where('type_operation', 'sortie')->get();
            $mouvement_teslins_retours = Testlin::where('type_operation', 'retour')->get();
            $stock_theorique = $mouvement_teslins_entrees->sum('quantite') + $mouvement_teslins_retours->sum('quantite') - $mouvement_teslins_sorties->sum('quantite');

            return view('testlin.liste', compact('stock_theorique', 'antennes', 'mouvement_teslins', 'mouvement_teslins_entrees', 'mouvement_teslins_sorties', 'mouvement_teslins_retours'));
        } else {
            return redirect()->back()->with('error', 'Vous ne disposer pas des droits réquis pour acceder a cette ressource !!');
        }
    }

    public function getById(Request $request)
    {
        $testlin = Testlin::find($request->id);

        return json_encode($testlin);
    }

    public function modifier(Request $request)
    {
        if (Auth::user()->can('gerer_teslin')) {
            if ($request->type_operation == 'entree') {
                $antenne_id = env('antenne_centre_id');
            } else {
                $antenne_id = $request->antenne;
            }
            $testlin = Testlin::find($request->testlin_id);
            $testlin->update([
                'antenne_id' => $antenne_id,
                'type_operation' => $request->type_operation,
                'quantite' => $request->quantite,
                'reference' => $request->reference,
                'date' => reformat_date($request->date),
                'modifier_par' => Auth::user()->id,
            ]);

            return redirect()->back()->with('success', 'Le mouvement du testlin a été modifiée avec success !!');
        } else {
            return redirect()->back()->with('error', 'Vous ne disposer pas des droits réquis pour acceder a cette ressource !!');
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
        if (Auth::user()->can('gerer_teslin')) {
            if ($request->type_operation == 'entree') {
                $antenne_id = env('antenne_centre_id');
            } else {
                $antenne_id = $request->antenne;
            }
            Testlin::create([
                'antenne_id' => $antenne_id,
                'type_operation' => $request->type_operation,
                'quantite' => $request->quantite,
                'reference' => $request->reference,
                'date' => reformat_date($request->date),
                'creer_par' => Auth::user()->id,
            ]);

            return redirect()->back()->with('success', 'Le mouvement enregistrer avec success!');
        } else {
            return redirect()->back()->with('error', 'Vous ne disposer pas des droits réquis pour acceder a cette ressource !!');
        }
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
