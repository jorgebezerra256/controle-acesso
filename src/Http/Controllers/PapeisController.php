<?php

namespace ControleAcesso\Http\Controllers;

use Illuminate\Http\Request;
use ControleAcesso\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use ControleAcesso\Models\{
    Papel,
    Permissao
};


class PapeisController extends Controller
{
    /**
     * Identificador de para o model Papel
     * 
     * @var int
     */
    private $id_papel;

    /**
     * Tela listar papeis
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {     
        checkPermissao('papel.listar');

        $caminhos = [
            ['url' => '/admin', 'titulo' => 'Home'],
            ['url' => '', 'titulo' => 'Controle de Acesso'],
            ['url' => '', 'titulo' => 'Papéis'],
        ];

        $papeis = Papel::all();
        return view('ca::papeis.papeis', compact('papeis', 'caminhos'));
    }

    /**
     * Lista dos papeis datatables
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function get_datatable(){
        checkPermissao('papel.listar');

        $papeis = Papel::query();
        
        return DataTables::eloquent($papeis)
        ->addColumn('action', function ($papel){
            $retorno = permissaoParaLinks($papel, 'papel.atualizar', 'papel.excluir', 'papeis.edit', 'papeis.destroy');
             //Permissão adicionar permissão ao papel
            if(\Auth::user()->can('papel.addpermissao', $papel)){
                $retorno .= '<a href="'. route("papeis.permissao",$papel->id) .'" class="btn btn-sm btn-primary"  style="margin-left: 5px;" '. ($papel->id == 1 ? 'disabled' : 'enabled') .'><i class="fas fa-plus"></i> Permissões</a>';
            }
           return $retorno;
        })->make(true);
    }
   
    /**
     * Lista das permissões pelo papel informado (datatables)
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function get_datatablePapelPermissao($id){   
        checkPermissao('papel.addpermissao');
        
        $this->id_papel = $id;
        $papel = Papel::find($id);
        $permissoes = $papel->permissoes();
        
        return DataTables::eloquent($permissoes)
        ->addColumn('action', function ($permissao){
            //Permissão exluir permissão do papel            
            if(\Auth::user()->can('papel.delpermissao', $permissao)){
                return '<form action="'.$this->id_papel.'/'.$permissao->id.'" method="post" class="delete">'. method_field("DELETE") . csrf_field() .'<button title="Remover Permissão" type="submit" data-toggle="confirmation" class="btn btn-sm btn-danger" ><i class="far fa-trash-alt"></i> Remover</button>
                </form>';            
            }else{
                return "";
            }
        })
        ->make(true); 
    }

    /**
     * Formulário para inserção de papel
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        checkPermissao('papel.criar');

         $caminhos = [
            ['url' => '/admin', 'titulo' => 'Home'],
            ['url' => '', 'titulo' => 'Controle de Acesso'],
            ['url' => '/admin/papeis', 'titulo' => 'Papéis'],
            ['url' => '', 'titulo' => 'Inserir'],
        ];
        
        return view('ca::papeis.create', compact('caminhos'));
    }

    /**
     * Salvar novo papel
     *
     * @param  \Illuminate\Http\Request  $request
     * 
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        checkPermissao('papel.criar');
        
        $papel = $request->all();

        Papel::create($papel);
        return redirect()
        ->route('papeis.index')
        ->with(['success' => 'Papel inserido com sucesso!']);
    }

    /**
     * Formulário para edição de papel
     *
     * @param  int  $id
     * 
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        checkPermissao('papel.atualizar');

        if(Papel::find($id)->nome == 'Admin'){
            return redirect()->route('papeis.index');
        }

        $papel = Papel::find($id);

        $caminhos = [
            ['url' => '/admin', 'titulo' => 'Home'],
            ['url' => '', 'titulo' => 'Controle de Acesso'],
            ['url' => route('papeis.index'), 'titulo' => 'Papéis'],
            ['url' => '', 'titulo' => 'Editar'],
        ];

        return view('ca::papeis.edit', compact('caminhos', 'papel'));
    }

    /**
     * Atualizar papel
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \ControleAcesso\Models\Papel  $papel
     * 
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Papel $papel)
    {        
        checkPermissao('papel.atualizar');

        $id = $papel->id;        
        if(Papel::find($id)->nome == 'Admin'){
            return redirect()->route('papeis.index');
        }
        
        if($request->nome != 'Admin'){
            $papel->update($request->all());
            return redirect()
            ->route('papeis.index')
            ->with('message', 'Papel "Admin" não pode ser alterado!');
        }
        
        return redirect()
        ->route('papeis.index')
        ->with('message', 'Papel atualizado com sucesso');        
    }

    /**
     * Remover papel
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        checkPermissao('papel.excluir');

        if(Papel::find($id)->nome == 'Admin'){
            return redirect()->route('papeis.index');
        }

        Papel::find($id)
        ->delete();      

        return redirect()
        ->route('papeis.index')
        ->with('message', 'Papel excluído com sucesso'); 
    }

    /**
     * Formulário inserir permissão a papel
     * 
     * @param int $id
     * 
     * @return \Illuminate\Http\Response
     */
    public function permissao($id){   
        checkPermissao('papel.addpermissao');

        $papel = Papel::find($id);

        if($papel->nome == 'Admin'){
            return redirect()
            ->route('papeis.index');
        }      
        $caminhos = [
            ['url' => '/admin', 'titulo' => 'Home'],
            ['url' => '', 'titulo' => 'Controle de Acesso'],
            ['url' => route('papeis.index'), 'titulo' => 'Papéis'],
            ['url' => '', 'titulo' => 'Permissões'],
        ];

        $permissoes = Permissao::all();
        return view('ca::papeis.permissao', compact('papel', 'caminhos', 'permissoes'));
    }

    /**
     * Adiciona permissão a papel 
     * 
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * 
     * @return \Illuminate\Http\Response
     */
    public function permissaoStore(Request $request, $id)
    {
       checkPermissao('papel.addpermissao');
        
        $papel = Papel::find($id);
        $dados = $request->all();
        $permissao = Permissao::find($dados['permissao_id']);

        $papel->adicionaPermissao($permissao);

        return redirect()->back();
    }

    /**
     * Remover permissão de papel
     * 
     * @param int $id
     * @param int $permissao_id
     * 
     * @return \Illuminate\Http\Response
     */
    public function permissaoDestroy($id, $permissao_id)
    {
        checkPermissao('papel.delpermissao');

        $papel = Papel::find($id);        
        $permissao = Permissao::find($permissao_id);

        $papel->removePermissao($permissao);

        return redirect()->back();
    }

}
