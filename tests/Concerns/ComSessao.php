<?php

namespace ControleAcesso\Tests\Concerns;

use ControleAcesso\Models\{User,Papel, Permissao};

Trait ComSessao
{
    /**
     * Cria um usuário, define ele como logado na aplicação e o adiciona ao retorno das views
     * 
     * @return $this
     */
    public function sessaoPadrao() //UserContract $user, $guard = null)
    {
        $this->carregarPermissoes();
        
        $user = User::factory(['id' => 0])->create();     
        $user->adicionaPapel('Admin');
        $user = User::find($user->id);

        view()->share('user', $user);
        
        return parent::actingAs($user);
        //->withSession($user);
        //->withSession(['banned' => false]);
    }

    /**
     * Criar os papeis e permissões e disponibiliza para uso
     * 
     */
    public function carregarPermissoes(){
        $this->artisan("db:seed", ['--class' => 'ControleAcesso\\Database\\Seeders\\DatabaseSeeder']);

        $permissoes = Permissao::with('papeis')->get();
        foreach ($permissoes as $permissao) {            
            \Gate::define($permissao->nome, function($user) use ($permissao){
                return $user->eAdmin() || $user->temUmPapelDestes($permissao->papeis);
            });
        }
    } 
}