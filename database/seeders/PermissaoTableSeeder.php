<?php

namespace ControleAcesso\Database\Seeders;

use Illuminate\Database\Seeder;
use ControleAcesso\Models\Permissao;

class PermissaoTableSeeder extends Seeder
{
    /**
     * Papula tabela permissoes
     *
     * @return void
     */
    public function run()
    {
        // Permissões relacionadas a Papel
        Permissao::firstOrCreate(array('nome' => 'papel.listar', 'descricao' => 'Listagem de papéis'));
        Permissao::firstOrCreate(array('nome' => 'papel.criar', 'descricao' => 'Inserção de papel'));
        Permissao::firstOrCreate(array('nome' => 'papel.atualizar', 'descricao' => 'Atualizar papel'));
        Permissao::firstOrCreate(array('nome' => 'papel.excluir', 'descricao' => 'Excluir papel'));
        Permissao::firstOrCreate(array('nome' => 'papel.addpermissao', 'descricao' => 'Adiciona permissões ao papel'));
        Permissao::firstOrCreate(array('nome' => 'papel.delpermissao', 'descricao' => 'Remove permissão do papel'));

        // Permissões relacionadas a Permissão
        Permissao::firstOrCreate(array('nome' => 'permissao.listar', 'descricao' => 'Listagem de permissões'));
        Permissao::firstOrCreate(array('nome' => 'permissao.criar', 'descricao' => 'Inserção de permissão'));
        Permissao::firstOrCreate(array('nome' => 'permissao.atualizar', 'descricao' => 'Atualizar permissão'));
        Permissao::firstOrCreate(array('nome' => 'permissao.excluir', 'descricao' => 'Exclui permissão'));

        // Permissões relacionadas a Usuário
        Permissao::firstOrCreate(array('nome' => 'usuario.listar', 'descricao' => 'Listagem de usuários'));
        Permissao::firstOrCreate(array('nome' => 'usuario.addpapel', 'descricao' => 'Permite adicionar papel a usuário'));
        Permissao::firstOrCreate(array('nome' => 'usuario.delpapel', 'descricao' => 'Permite remover papel de usuário'));

    }    
}
