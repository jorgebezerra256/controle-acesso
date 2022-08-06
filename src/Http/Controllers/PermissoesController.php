<?php

namespace ControleAcesso\Http\Controllers;

use Illuminate\Http\Request;
use ControleAcesso\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use ControleAcesso\Models\Permissao;


class PermissoesController extends Controller
{
    /**
     * Tela listar permissões
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->checkPermissao('permissao.listar');

        $caminhos = [
            ['url' => '/admin', 'titulo' => 'Home'],
            ['url' => '', 'titulo' => 'Controle de Acesso'],
            ['url' => '', 'titulo' => 'Permissões'],
        ];

        $permissoes = Permissao::all();
        return view('ca::permissoes.permissoes', compact('permissoes', 'caminhos'));
    }

    /**
     * Listar permissões (datatables)
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function get_datatable(){
        $this->checkPermissao('permissao.listar');

        $permissoes = Permissao::query();
        
        return DataTables::eloquent($permissoes)
        ->addColumn('action', function ($permissao){            
            return permissaoParaLinks($permissao, 'permissao.atualizar', 'permissao.excluir', 'permissoes.edit', 'permissoes.destroy');            
        })->make(true);
    }
    
    /**
     * Formulário inserir permissão
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->checkPermissao('permissao.criar');

        $caminhos = [
            ['url' => '/admin', 'titulo' => 'Home'],
            ['url' => '', 'titulo' => 'Controle de Acesso'],
            ['url' => '/admin/permissoes', 'titulo' => 'Permissões'],
            ['url' => '', 'titulo' => 'Inserir'],
        ];
        
        return view('ca::permissoes.create', compact('caminhos'));
    }

    /**
     * Salvar permissão
     *
     * @param  \Illuminate\Http\Request  $request
     * 
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->checkPermissao('permissao.criar');

        $permissao = $request->all();
        Permissao::create($permissao);
        return redirect()->route('permissoes.index')
        ->with(['success' => 'Permissão inserida com sucesso!']);
    }
    
    /**
     * Formulário editar permissão
     *
     * @param  int  $id
     * 
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->checkPermissao('permissao.atualizar');

        $permissao = Permissao::find($id);

        $caminhos = [
            ['url' => '/admin', 'titulo' => 'Home'],
            ['url' => '', 'titulo' => 'Controle de Acesso'],
            ['url' => route('permissoes.index'), 'titulo' => 'Permissões'],
            ['url' => '', 'titulo' => 'Editar'],
        ];

        return view('ca::permissoes.edit', compact('caminhos', 'permissao'));
    }

    /**
     * Atualizar permissão
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \ControleAcesso\Models\Permissao  $permissao
     * 
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Permissao $permissao)
    {                
        $this->checkPermissao('permissao.atualizar');

        $permissao->update($request->all());
        
        return redirect()
        ->route('permissoes.index')
        ->with('success', 'Permissão atualizada com sucesso');
    }

    /**
     * Remove permissão
     *
     * @param  int  $id
     * 
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->checkPermissao('permissao.excluir');

        Permissao::find($id)->delete();      
        return redirect()
        ->route('permissoes.index')
        ->with('success', 'Permissão excluída com sucesso'); 
    }
}
