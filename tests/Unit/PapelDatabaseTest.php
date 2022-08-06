<?php

namespace ControleAcesso\Tests\Unit;

use ControleAcesso\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use ControleAcesso\Models\{User, Papel, Permissao};
//use App\Models\User;
use PhpParser\Node\Expr\FuncCall;
use ControleAcesso\Database\Factories\UserFactory;

// use Illuminate\Foundation\Testing\WithFaker;

class PapelDatabaseTest extends TestCase
{ 
    use RefreshDatabase; //, WithFaker;

    /**
     * @param string
     * Nome da tabela
     */
    protected $table = 'papeis';

    /**
     * @test
     * Teste de inserção de papel
     */
    public function criaPapel()
    {
        $papel = Papel::factory()->create();

        $this->assertDatabaseHas($this->table, $papel->toArray());
    }

    /**
     * @test
     * Teste de inserção de permissão
     */
    public function criaPermissao()
    {
        $permissao = Permissao::factory()->create();

        $this->assertDatabaseHas('permissoes', $permissao->toArray());
    }

    /**
     * @test
     * Testa inserção de permissão ao papel
     */
    public function papelTemPermissao()
    {
        $papel = Papel::factory()
        ->has(Permissao::factory()->count(4), 'permissoes')
        ->create();

        $this->assertDatabaseCount($this->table, 1);
        $this->assertDatabaseCount('permissoes', 4);
        //dd($papel->permissoes->toArray());
        //$this->assertDatabaseHas('permissoes', $papel->permissoes->toArray());
        $permissao = Permissao::factory()->create();

        $papel->adicionaPermissao($permissao->nome);
        
        $this->assertEquals(5, $papel->permissoes->count());

        $papel->removePermissao($permissao->nome);
        
        $papel = Papel::find($papel->id);
        $this->assertEquals(4, $papel->permissoes->count());
    }

    /**
     * @test
     * Testa relacionamento usuario, papel, permissão
     */
    public function usuarioTemPapelPermissao()
    {        
        $papel = Papel::factory()
        ->has(User::factory()->count(3), 'users')
        ->has(Permissao::factory()->count(4), 'permissoes')
        ->create();

        $this->assertEquals(3, $papel->users->count());

        $user = User::factory()->create();
        $user->adicionaPapel($papel->nome);

        $user = User::find($user->id);
        //dd($user->papeis);
        $this->assertEquals(1, $user->papeis->count());
        $permissoes = $user->papeis->first()->permissoes;
        $this->assertEquals(4, $permissoes->count());

        $user->removePapel($papel->nome);
        $user = User::find($user->id);
        $this->assertEquals(0, $user->papeis->count());
    }

}