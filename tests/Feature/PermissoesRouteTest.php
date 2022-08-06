<?php

namespace ControleAcesso\Tests\Feature;

use ControleAcesso\Models\Permissao;
// use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;

class PermissoesRouteTest extends TestFeature
{

    /**
     * @test
     * Testa rota permissões index
     */
    public function rotaIndex()
    {
        $response = $this->sessaoPadrao()
        ->get(route('permissoes.index'));

        $response->assertStatus(200);
    }

    /**
     * @test
     * Testa rota inserir permissão
     */
    public function routeCreate()
    {
        $response = $this->sessaoPadrao()
        ->withViewErrors([])
        ->get(route('permissoes.create'));

        $response->assertStatus(200);
    }
    
    /**
     * @test
     * Testa rota salvar permissão
     */
    public function routeStore()
    {
        $permissao = Permissao::factory()->make();

        $response = $this
        ->sessaoPadrao()
        ->post(route('permissoes.store', $permissao->toArray()));

        $response->assertRedirect(route('permissoes.index'))
        ->assertSessionHas('success');

    }

    /**
     * @test
     * Testa rota edição de permissão
     */
    public function routeEdit()
    {
        $permissao = Permissao::factory()->create();

        $response = $this->withViewErrors([])
        ->sessaoPadrao()
        ->get(route('permissoes.edit', $permissao->id));

        $response->assertStatus(200);
    }

    /**
     * @test
     * Testa rota atualizar permissão
     */
    public function routeUpdate()
    {
        $permissao = Permissao::factory()->create();
        $p = Permissao::factory()->make();
        $p->id = $permissao->id;

        $this->app->instance(Permissao::class, $permissao);
        $response = $this->sessaoPadrao()
        ->put(route('permissoes.update', $permissao, $p));

        $response->assertRedirect(route('permissoes.index'))
        ->assertSessionHas('success');
    }

    /**
     * @test
     * Testa rota excluir permissão
     */
    public function routeDestroy()
    {
        $permissao = Permissao::factory()
        ->create();

        $response = $this->sessaoPadrao()
        ->delete(route('permissoes.destroy', $permissao->id));

        $response->assertRedirect(route('permissoes.index'))
        ->assertSessionHas('success');
    }

    /**
     * @test
     * Testa rota listagem de permissões datatables
     */
    public function routeGetDatatable()
    {
        $permissao = Permissao::factory()
        ->count(10)
        ->create();
        
        $response = $this->sessaoPadrao()
        ->post('/admin/permissoes/get_datatable');

        $totalPermissoes = Permissao::all()->count();

        
        $response->assertStatus(200)
        ->assertJson(function (AssertableJson $json) use ($totalPermissoes) {
            $json->where('recordsTotal', $totalPermissoes)
            ->etc();
        });
    }

}