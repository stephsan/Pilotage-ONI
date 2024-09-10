<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ParametreController;
use App\Http\Controllers\ValeurController;
use App\Http\Controllers\CentreCollecteController;
use App\Http\Controllers\FormulaireController;
use App\Http\Controllers\CentreTraitementController;
use App\Http\Controllers\AnteneController;
use App\Http\Controllers\RecetteQuittanceController;
use App\Http\Controllers\RecetteController;
use App\Http\Controllers\EntiteController;
use App\Http\Controllers\RegistreController;
use App\Http\Controllers\StatistiqueController;
use App\Http\Controllers\TacheController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [UserController::class, 'login']);
Route::post('logout', [UserController::class, 'logout'])->name('logout');
Route::resource('user', UserController::class);
Route::resource('permissions', PermissionController::class);
Route::resource("role",RoleController::class);
Route::resource("antenne",AnteneController::class);
Route::resource("recette",RecetteController::class);
Route::resource("parametre",ParametreController::class);
Route::resource("valeur", ValeurController::class);
Route::resource("formulaire_prod", FormulaireController::class);
Route::resource("centreCollecte", CentreCollecteController::class);
Route::resource("centreTraitement", CentreTraitementController::class);
Route::resource("recette_quittance", RecetteQuittanceController::class);
// Route::resource("statistique", StatistiqueController::class);
Route::resource('tache', TacheController::class);
Route::get('/getById/tache', [TacheController::class, 'getById'])->name("tache.getById");
Route::get('/viewById/tache', [TacheController::class, 'viewById'])->name("tache.viewById");

Route::get('/changeStatus/tache', [TacheController::class, 'changeStatus'])->name("tache.changeStatus");

Route::post('/modifier/tache', [TacheController::class, 'modifier'])->name("tache.modifier");

Route::get('/value', [ValeurController::class, 'selection'])->name("valeur.selection");
Route::post('/modifier/c-collecte', [CentreCollecteController::class, 'modifier'])->name("centreCollecte.modifier");
Route::get('/getById/c-collecte/', [CentreCollecteController::class, 'getById'])->name("centreCollecte.getById");
Route::get('/getById/c-traitement/', [CentreTraitementController::class, 'getById'])->name("centreTraitement.getById");
Route::post('/modifier/c-traitement', [CentreTraitementController::class, 'modifier'])->name("centreTraitement.modifier");
Route::get('/getById/formulaire_prod', [FormulaireController::class, 'getById'])->name("formulaire_prod.getById");
Route::post('/modifier/formulaire_prod', [FormulaireController::class, 'modifier'])->name("formulaire_prod.modifier");
Route::get('/getById/quittance', [RecetteQuittanceController::class, 'getById'])->name("quittance.getById");
Route::post('/modifier/quittance', [RecetteQuittanceController::class, 'modifier'])->name("quittance.modifier");
Route::get('/recap/quittance', [RecetteQuittanceController::class, 'etat_recap'])->name("formulaire.etat");
Route::get('/verifier/saisie/quittance', [FormulaireController::class, 'verifier_saisie'])->name("quittance.verifier_saisie");
Route::get('/detail/saisie/quittance_ccd/{ctid}', [RecetteQuittanceController::class, 'details_ccd'])->name("detail.quittance_ccd");
Route::get('/getById/recette', [RecetteController::class, 'getById'])->name("recette.getById");
Route::get('/getById/antenne', [AnteneController::class, 'getById'])->name("antenne.getById");
Route::post('/modifier/recette', [RecetteController::class, 'modifier'])->name("recette.modifier");
Route::get('/valider/recette', [RecetteController::class, 'valider'])->name("recette.valider");
Route::get('/synthese/recette', [RecetteController::class, 'synthese'])->name("recette.synthese");
Route::post('/modifier/antenne', [AnteneController::class, 'modifier'])->name("antenne.modifier");
Route::get('/formulaire_recu', [FormulaireController::class, 'liste_save_formulaire_recus'])->name("formulaire_recu.liste");
Route::get('/getById/formulaire_recu', [FormulaireController::class, 'getFormulaire_recusById'])->name("formulaire_recu.getById");
Route::post('/modifier/formulaire_recu', [FormulaireController::class, 'modifier_formulaire_recus'])->name("formulaire_recu.modifier");
Route::post('/save/formulaire_recu', [FormulaireController::class, 'save_formulaire_recus'])->name("formulaire_recu.save");
Route::get('/selectCtid/ByAntenne', [CentreTraitementController::class, 'select_ctids_byAntenne'])->name("ctids.selection");
Route::get('/selectCommune/ByCtid', [CentreTraitementController::class, 'select_commune_byCtid'])->name("communes.selection");
Route::get('/selectAntenne/ByRegionId', [CentreTraitementController::class, 'select_antennes_byRegionId'])->name("antenne.selection");
Route::get('/getById/entite', [EntiteController::class, 'getById'])->name("entite.getById");
Route::resource("entite", EntiteController::class);
Route::post('/modifier/entite', [EntiteController::class, 'modifier'])->name("entite.modifier");
Route::resource("registre", RegistreController::class);
Route::get('/getById/registre', [RegistreController::class, 'getById'])->name("registre.getById");
Route::post('/modifier/registre', [RegistreController::class, 'modifier'])->name("registre.modifier");
Route::get('/rapport/journalier/', [RegistreController::class, 'rapport_journalier'])->name("registre.rapport_journalier");
Route::post('/rapport/journalierByDate/', [RegistreController::class, 'rapport_journalier_by_date'])->name("registre.rapport_journalier_bydate");
Route::post('store/sortie/formulaire/',[FormulaireController::class, 'store_formulaire_sortie'])->name("formulaire.sortie");
Route::get('recette/par/antenne',  [DashboardController::class, 'recette_par_antenne'] )->name("recette.antenne");
Route::get('prod_cnib/par/antenne',  [DashboardController::class, 'carte_imprime_par_antenne'] )->name("production.antenne");
Route::get('formulaire/par/antenne',  [DashboardController::class, 'formulaire_par_antenne'] )->name("formulaire.antenne");










Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'dash_principal'])->name('dashboard');
});
