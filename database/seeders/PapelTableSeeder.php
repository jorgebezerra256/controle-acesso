<?php

namespace ControleAcesso\Database\Seeders;

use Illuminate\Database\Seeder;
use ControleAcesso\Models\Papel;

class PapelTableSeeder extends Seeder
{
    /**
     * Popula tabela papeis
     *
     * @return void
     */
    public function run()
    {
    	//DB::table('papeis').delete();    	
        $admin = Papel::firstOrCreate(['nome' => 'Admin', 'descricao' => 'Administador do Sistema']);
        $admin->adicionaPermissao('papel.listar');
        $admin->adicionaPermissao('papel.criar');
        $admin->adicionaPermissao('papel.atualizar');
        $admin->adicionaPermissao('papel.excluir');
        $admin->adicionaPermissao('papel.addpermissao');
        $admin->adicionaPermissao('papel.delpermissao');
        $admin->adicionaPermissao('permissao.listar');
        $admin->adicionaPermissao('permissao.criar');
        $admin->adicionaPermissao('permissao.atualizar');
        $admin->adicionaPermissao('permissao.excluir');
    }
}
