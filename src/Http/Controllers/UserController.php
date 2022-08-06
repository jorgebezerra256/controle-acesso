<?php

namespace ControleAcesso\Http\Controllers;

use Illuminate\Http\Request;
use ControleAcesso\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use ControleAcesso\Models\{
    User,
    Papel
};
use Auth;


class UserController extends Controller
{
    /**
     * Tela listagem de usuários
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        checkPermissao('usuario.listar');

        $caminhos = [
            ['url' => '/admin', 'titulo' => 'Home'],
            ['url' => '', 'titulo' => 'Controle de Acesso'],
            ['url' => '', 'titulo' => 'Usuários'],
        ];

        $usuarios = User::all();
        return view('ca::usuarios.users', compact('usuarios', 'caminhos'));
    }

    /**
     * Tela listagem dos papeis para determinado usuário
     * 
     * @param int $id
     * 
     * @return \Illuminate\Http\Response
     */
    public function papel($id){  
        checkPermissao('usuario.addpapel');
    
        $caminhos = [
            ['url' => '/admin', 'titulo' => 'Home'],
            ['url' => '', 'titulo' => 'Controle de Acesso'],
            ['url' => route('users.index'), 'titulo' => 'Usuários'],
            ['url' => '', 'titulo' => 'Papel'],
        ];
      
        $usuario = User::find($id);
        $papeis = Papel::all();

        return view('ca::usuarios.papel', compact('papeis', 'caminhos', 'usuario'));
    }

    /**
     * Adicionar papel a usuário
     * 
     * @param \Illuminate\Http\Request $request
     * @param int $id
     */
    public function papelStore(Request $request, $id)
    {
        checkPermissao('usuario.addpapel');
        
        $usuario = User::find($id);
        $dados = $request->all();
        $papel = Papel::find($dados['papel_id']);

        $usuario->adicionaPapel($papel);

        return redirect()->back();
    }

    /**
     * Remover papel de usuário
     * 
     * @param int $id
     * @param int $papel_id
     */
    public function papelDestroy($id, $papel_id)
    {
        checkPermissao('usuario.delpapel');

        $usuario = User::find($id);        
        $papel = Papel::find($papel_id);

        $usuario->removePapel($papel);

        return redirect()->back();

    }

    /**
     * Listagem de usuários (datatables)
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function get_datatable(){

        checkPermissao('usuario.listar');

        $users = User::query();
        
        return DataTables::eloquent($users)
        ->addColumn('action', function ($user){    
            //dd($user);
            //Perm,issão adicionar papel ao usuario
            if(\Auth::user()->can('usuario.addpapel', $user)){        
                return '<a href="'. route('users.papel',$user->id) .'" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-list-alt"></i> Papeis</a>';
            }else{
                return "";
            }                        
        })
        ->make(true);
    }

    /**
     * Lista os papeis de determinado usuário (datatables)
     * 
     * @param int $user
     * 
     * @return \Illuminate\Http\JsonreRponse
     */
    public function get_datatableUsuarioPapel($user){   

        checkPermissao('usuario.addpapel');

        //usuario             
        $usuario = User::where('id', '=', $user)->first();        
        //Permissões desse usuário
        $papeis = $usuario->papeis();
        
        return DataTables::eloquent($papeis)
        ->addColumn('action', function ($papel) use ($usuario){  
            //Permissão excluir papel
            if(Auth::user()->can('usuario.delpapel', $papel)){          
                return '<form class="delete" action="'.$usuario->id.'/'.$papel->id.'" method="post">'. method_field("DELETE") . csrf_field() .'<button value="Deletar" type="submit" data-toggle="confirmation" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-trash"></i>Delete</button>
                </form>'; 
            }else{
                return "";
            }          
        })
        ->make(true);    
    }

}
