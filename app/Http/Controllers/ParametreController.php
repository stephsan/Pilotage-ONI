<?php

namespace App\Http\Controllers;

use App\Models\Parametre;
use Illuminate\Http\Request;

class ParametreController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $parametres = Parametre::all();
        return view('parametre.index', compact('parametres'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $parametres = Parametre::all();
        return view('parametre.create', compact('parametres'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Parametre::create([
          'parametre_id'=>$request->parent,
           'libelle'=>$request->libelle,
           'description'=>$request->description,
           ]);
           return redirect( route('parametre.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Parametre  $parametre
     * @return \Illuminate\Http\Response
     */
    public function show(Parametre $parametre)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Parametre  $parametre
     * @return \Illuminate\Http\Response
     */
    public function edit(Parametre $parametre)
    {
        $params = Parametre::all();
        return view('parametre.edit', compact('parametre', 'params'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Parametre  $parametre
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Parametre $parametre)
    {
        $parametre->libelle = $request->libelle;
        $parametre->description = $request->description;
        $parametre->parametre_id = $request->parent;
        $parametre->save();
        // Flashy::message('Parametre Supprimer avec succes');
        return redirect(route('parametre.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Parametre  $parametre
     * @return \Illuminate\Http\Response
     */
    public function destroy( $id)
    {
        Parametre::destroy($id);
        return redirect( route('parametre.index'));
    }
}
