<?php

namespace App\Http\Controllers;

use App\Models\Parametre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class ParametreController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        if (Auth::user()->can('gerer_parametre')) { 
            $parametres = Parametre::all();
            return view('parametre.index', compact('parametres'));
        }
        else{
            return redirect()->back()->with('error',"Vous n'avez pas la permission pour effectuer cette action!");
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Auth::user()->can('gerer_parametre')) { 
            $parametres = Parametre::all();
            return view('parametre.create', compact('parametres'));
        }
        else{
            return redirect()->back()->with('error',"Vous n'avez pas la permission pour effectuer cette action!");
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    if (Auth::user()->can('gerer_parametre')) { 
        Parametre::create([
          'parametre_id'=>$request->parent,
           'libelle'=>$request->libelle,
           'description'=>$request->description,
           ]);
           return redirect( route('parametre.index'));
        }
        else{
            return redirect()->back()->with('error',"Vous n'avez pas la permission pour effectuer cette action!");
        }
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
        if (Auth::user()->can('gerer_parametre')) { 
            $params = Parametre::all();
            return view('parametre.edit', compact('parametre', 'params'));
        }
        else{
            return redirect()->back()->with('error',"Vous n'avez pas la permission pour effectuer cette action!");
        }
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
        if (Auth::user()->can('gerer_parametre')) { 
            $parametre->libelle = $request->libelle;
            $parametre->description = $request->description;
            $parametre->parametre_id = $request->parent;
            $parametre->save();
        // Flashy::message('Parametre Supprimer avec succes');
        return redirect(route('parametre.index'));
        }
        else{
            return redirect()->back()->with('error',"Vous n'avez pas la permission pour effectuer cette action!");
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Parametre  $parametre
     * @return \Illuminate\Http\Response
     */
    public function destroy( $id)
    {
    if (Auth::user()->can('gerer_parametre')) { 
        Parametre::destroy($id);
        return redirect( route('parametre.index'));
    }
    else{
        return redirect()->back()->with('error',"Vous n'avez pas la permission pour effectuer cette action!");
    }
    }
}
