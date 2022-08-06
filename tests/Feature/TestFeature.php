<?php

namespace ControleAcesso\Tests\Feature;

use ControleAcesso\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use ControleAcesso\Models\User;

class TestFeature extends TestCase
{
    use RefreshDatabase;

    public function setUp() : void
    {
        parent::setUp();
        // Ignorar autenticação
        // $this->withoutMiddleware();
        // Ignorar mix-manifest
        $this->withoutMix();

        $this->carregarPermissoes();
    }

    /**
     * Cria um usuário, define ele como logado na aplicação e o adiciona ao retorno das views
     * 
     * @return $this
     */
    public function sessaoPadrao() //UserContract $user, $guard = null)
    {
        $user = User::factory(['id' => 0])->create();
        $user->adicionaPapel('Admin');
        $user = User::find($user->id);

        view()->share('user', $user);

        return parent::actingAs($user);
        //->withSession($user);
        //->withSession(['banned' => false]);
    }
}