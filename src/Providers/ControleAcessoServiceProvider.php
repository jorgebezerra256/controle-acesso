<?php

namespace ControleAcesso\Providers;

use Illuminate\Support\ServiceProvider;

class ControleAcessoServiceProvider extends ServiceProvider
{
    /**
     * Inicialização dos serviços
     * 
     * @return void
     */
    public function boot()
    {        
        $this->loadRoutesFrom(CONTROLE_ACESSO_PATH.'/routes/web.php');        
        $this->loadMigrationsFrom(CONTROLE_ACESSO_PATH.'/database/migrations/');
        $this->loadViewsFrom(CONTROLE_ACESSO_PATH.'/resources/views/', 'ca');          
       
    }

    /**
     * Registra os servições para a plicação
     * 
     * @return void
     */
    public function register()
    {   
        if (!defined('CONTROLE_ACESSO_PATH')) {
            define('CONTROLE_ACESSO_PATH', realpath(__DIR__.'/../../'));
        }
    }
}