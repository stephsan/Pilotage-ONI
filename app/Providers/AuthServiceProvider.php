<?php

namespace App\Providers;
use App\Policies\RolePolicy;
use App\Policies\ParametrePolicy;
use App\Policies\ValeurPolicy;
use App\Policies\UserPolicy;
use App\Policies\FormulairePolicy;
use App\Policies\RecettePolicy;
use App\Policies\RegistrePolicy;
use App\Policies\DashboadboardPolicy;
use App\Policies\TachePolicy;

 use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
        $this->registerPolicies();
        Gate::resource('role', RolePolicy::class);
        Gate::resource('valeur', ValeurPolicy::class);
        Gate::resource('user', UserPolicy::class);
        Gate::resource('parametre', UserPolicy::class);
        Gate::resource('user', UserPolicy::class);
        
        Gate::define('gerer_user', [UserPolicy::class, 'gerer_user'] );
        Gate::define('gerer_parametre', [ParametrePolicy::class, 'gerer_parametre'] );
        Gate::define('gerer_entite', [ParametrePolicy::class, 'gerer_entite'] );

        Gate::resource('recette', RecettePolicy::class);
        Gate::resource('formulaire', FormulairePolicy::class);
        Gate::define('recette.valider', [RecettePolicy::class, 'valider'] );
        Gate::define('recette.synthese', [RecettePolicy::class, 'synthese'] );
        Gate::define('quittance.lister', [RecettePolicy::class, 'lister_quittance_recette'] );
        Gate::define('create_quittance_recette', [RecettePolicy::class, 'creer_quittance_recette'] );
        Gate::define('formulaire.receptionner', [FormulairePolicy::class, 'receptionne'] );
        Gate::define('formulaire.update_reception', [FormulairePolicy::class, 'update_reception'] );
        Gate::define('formulaire.recap', [FormulairePolicy::class, 'recap_formulaire'] );

        Gate::define('tache.create', [TachePolicy::class, 'create'] );
        Gate::define('tache.view', [TachePolicy::class, 'view'] );
        Gate::define('acceder_a_la_synthese', [RegistrePolicy::class, 'acceder_a_la_synthese'] );
        Gate::define('modifier_quittance_recette', [RecettePolicy::class, 'modifier_quittance_recette'] );
        Gate::define('modifier_le_registre', [RegistrePolicy::class, 'modifier_le_registre'] );
        Gate::define('acceder_au_registre', [RegistrePolicy::class, 'acceder_au_registre'] );
        Gate::define('enregistrer_dans_le_registre', [RegistrePolicy::class, 'enregistrer_dans_le_registre'] );
        Gate::define('acceder_au_dashboard', [DashboadboardPolicy::class, 'acceder_au_dashboard'] );
        
        

        
    }
  
}
