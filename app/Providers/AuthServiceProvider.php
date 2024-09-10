<?php

namespace App\Providers;
use App\Policies\RolePolicy;
use App\Policies\ParametrePolicy;
use App\Policies\ValeurPolicy;
use App\Policies\UserPolicy;
use App\Policies\FormulairePolicy;
use App\Policies\RecettePolicy;
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
        Gate::resource('recette', RecettePolicy::class);
        Gate::resource('formulaire', FormulairePolicy::class);
        Gate::define('recette.valider', [RecettePolicy::class, 'valider'] );
        Gate::define('quittance.lister', [RecettePolicy::class, 'lister_quittance_recette'] );
        Gate::define('quittance.create', [RecettePolicy::class, 'creer_quittance_recette'] );
        Gate::define('formulaire.receptionner', [FormulairePolicy::class, 'receptionne'] );
        Gate::define('formulaire.update_reception', [FormulairePolicy::class, 'update_reception'] );
        Gate::define('tache.create', [TachePolicy::class, 'create'] );
        Gate::define('tache.view', [TachePolicy::class, 'view'] );
    }
  
}
