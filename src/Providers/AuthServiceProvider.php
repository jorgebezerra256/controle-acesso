<?php

namespace ControleAcesso\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use ControleAcesso\Models\Permissao;

class AuthServiceProvider extends ServiceProvider
{    
    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {       
        $this->registerPolicies();        
        
        foreach ($this->listaPermissoes() as $permissao) {            
            Gate::define($permissao->nome, function($user) use ($permissao){
                return $user->eAdmin() || $user->temUmPapelDestes($permissao->papeis);
            });
        }
    }

    /**
     * Carrega a lista de permissões do sistema
     * 
     * @return Permissao[]
    */
    public function listaPermissoes(){            
        try{
            if(\Schema::hasTable('papeis')){
                return Permissao::with('papeis')->get();
            }
            return [];
        }catch(\Exception $e){
            echo 'Erro ao carregar lista de permissões! '. $e->getMessage();
        }
    }
}
