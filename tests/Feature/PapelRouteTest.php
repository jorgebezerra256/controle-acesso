<?php

namespace ControleAcesso\Tests\Feature;

use ControleAcesso\Models\{Papel, Permissao};
// use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;

class PapelRouteTest extends TestFeature
{    
    /**
     * @test
     * Testa rota index
     */
    public function rotaIndex()
    {        
        $response = $this->sessaoPadrao()
        ->get(route('papeis.index'));
        
        $response->assertStatus(200);
    }

    /**
     * @test
     * Testa a rota criar papeis
     */
    public function rotaCreate()
    {
        $response = $this
        ->withViewErrors([])
        ->sessaoPadrao()
        ->get(route('papeis.create'));

        $response->assertStatus(200);

    }

    /**
     * @test
     * Testa rota de inserção
     */
    public function rotaStore()
    {
        $papel = Papel::factory()->make();
        //dd($papel);
        $response = $this->sessaoPadrao()
        ->postJson(route('papeis.store', $papel->toArray()));
        
        $response->assertRedirect(route('papeis.index'))
        ->assertSessionHas('success');
        //->assertSessionHas('success','Papel inserido com sucesso!');
       //->assertStatus(302);

       //$response->ddSession();
    }

    /**
     * @test
     * Testa rota de edição
     */
    public function rotaEdit()
    {
        $papel = Papel::factory()->create();
        $response = $this->withViewErrors([])
        ->sessaoPadrao()
        ->get(route('papeis.edit', $papel->id));

        $response->assertStatus(200);
    }

    /**
     * @test
     * Testa rota de atualização
    */
    public function rotaUpdate()
    {
        $papel = Papel::factory()->create();
        $p = Papel::factory()->make();        
        $p->id = $papel->id;
        
        // Injeta Papel no container de dependências
        $this->app->instance(Papel::class, $papel);
                
        $response = $this
        ->sessaoPadrao()
        ->put(route('papeis.update', [$papel, $p]));
        
        $response->assertRedirect(route('papeis.index'))
        ->assertSessionHas('message');
    }

    /**
     * @test
     * Testa rota excluir
     */
    public function rotaDestroy()
    {
        $papel = Papel::factory()->create();

        $response = $this->sessaoPadrao()
        ->delete(route('papeis.destroy', $papel->id));

        $response->assertRedirect(route('papeis.index'))
        ->assertSessionHas('message');

    }

    /**
     * @test
     * Testa listagem de papeis
     */
    public function routeGetDatatables()
    {
        $response = $this->sessaoPadrao()
        ->post('/admin/papeis/get_datatablePapeis');

        $response->assertStatus(200);
    }
    
    /**
     * @test
     * Testa listagem de permissões por papel
     */
    public function roteGetDatatablePapelPermissao()
    {
        $papel = Papel::factory()
        ->has(Permissao::factory()->count(25), 'permissoes')
        ->create();

        $response = $this->sessaoPadrao()
        ->post('/admin/papeis/get_datatablePapelPermissao/'.$papel->id);

        $response
        ->assertJson(function(AssertableJson $json){
            $json->where('recordsTotal', 25)
            ->etc();
            }
        );
    }

    /**
     * @test
     * Testa listagem de permissoes por papel
     */
    public function routePermissao()
    {
        $papel = Papel::factory()
        ->has(Permissao::factory()
        ->count(12), 'permissoes')
        ->create();

        $response = $this->withViewErrors([])
        ->sessaoPadrao()
        ->get(route('papeis.permissao', $papel->id));

        $response->assertStatus(200);
    }

    /**
     * @test
     * Testa rota de adiçâo de permissâo a papel
     */
    public function routePermissaoStore()
    {
        $papel = Papel::factory()        
        ->create();
        $permissao = Permissao::factory()->create();
        
        $response = $this->withViewErrors([])
        ->sessaoPadrao()
        ->withHeader('HTTP_REFERER', route('papeis.permissao', $papel->id))
        ->post(route('papeis.permissao.store', [$papel, 'permissao_id' => $permissao->id]));

        $response->assertStatus(302)
        ->assertRedirect(route('papeis.permissao', $papel->id));

    }

    /**
     * @test
     * Testa rota de remoção de permissão a papel
     */
    public function routePermissaoDestroy()
    {
        $papel = Papel::factory()
        ->has(Permissao::factory()->count(4), 'permissoes')
        ->create();

        $permissao = $papel->permissoes->first();
        
        $response = $this->withViewErrors([])
        ->sessaoPadrao()
        ->withHeader('HTTP_REFERER' , route('papeis.index'))
        ->delete(route('papeis.permissao.destroy', [$papel, $permissao]));
        
        $response->assertRedirect(route('papeis.index'));

    }

}