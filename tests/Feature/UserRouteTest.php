<?php

namespace ControleAcesso\Tests\Feature;

use ControleAcesso\Models\{user, Papel, Permissao};
use Illuminate\Testing\Fluent\AssertableJson;

class UserRouteTest extends TestFeature
{

    /**
     * @test
     * Testa rota user index
     */
    public function rotaIndex()
    {
        $response = $this->sessaoPadrao()
        ->get(route('users.index'));
        
        $response->assertStatus(200);
    }

            
    /**
     * @test
     * Testa rota listagem de usuários
     */
    public function routeGetDatatable()
    {
        User::factory()
        ->count(10)
        ->create();

        $response = $this->sessaoPadrao()
        ->post('/admin/usuarios/get_datatableUsuarios');

        $totalUser = User::all()->count();        

        $response->assertStatus(200)
        ->assertJson(function (AssertableJson $json) use ($totalUser) {
            $json->where('recordsTotal', $totalUser)
            ->etc();
        });
    }

    /**
     * @test
     * Testa rota listagem de papeis por usuário
     */
    public function routeGetDatatableUsuarioPapel()
    {
        $user = User::factory()
        ->has(Papel::factory()->count(5), 'papeis')
        ->create();

        $response = $this->sessaoPadrao()
        ->post("/admin/usuarios/get_datatableUsuarioPapel/$user->id");

        $totalPapel = $user->papeis->count();        
        
        $response->assertStatus(200)
        ->assertJson(function (AssertableJson $json) use ($totalPapel) {
            $json->where('recordsTotal', $totalPapel)
            ->etc();
        });
    }

    /**
     * @test
     * Testa rota lista de papel para atribuição a usuário
     */
    public function routeUserPapel()
    {
        $user = User::factory()->create();

        $response = $this->sessaoPadrao()        
        ->withViewErrors([])
        ->get(route('users.papel', $user));

        $response->assertStatus(200);
    }

    /**
     * @test
     * Testa rota adicionar papel ao usuário
     */
    public function routeUserPapelStore()
    {
        $user = User::factory()->create();
        $papel = Papel::factory()->create();
        $response = $this->sessaoPadrao()
        ->withHeader('HTTP_REFERER', route('users.papel', $user))
        ->post(route('users.papel.store', ['id' => $user, 'papel_id' => $papel->id]));

        $response->assertRedirect(route('users.papel', $user));

    }

    /**
     * @test
     * Testa rota remover papel do usuário
     */
    public function routePapelUserDestroy()
    {
        $user = User::factory()
        ->has(Papel::factory()->count(5), 'papeis')
        ->create();

        $papel = $user->papeis->first();

        $response = $this->sessaoPadrao()
        ->withHeader('HTTP_REFERER', route('users.papel', $user))
        ->delete(route('users.papel.destroy', [$user, $papel]));

        $response->assertRedirect(route('users.papel', $user));


    }

}