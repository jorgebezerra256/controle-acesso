<?php

/**
 * Retorna formatação HTML de links dos quais usuário tem permissão
 * 
 * @param Illuminate\Database\Eloquent\Model $model
 * @param string $permissaoAtualizar
 * @param string $permissaoExcluir
 * @param string $rotaEditar
 * @param string $rotaExcluir
 * 
 * @return string
 */
if(!function_exists('permissaoParaLinks')){
    function permissaoParaLinks($model, $permisaoAtualizar, $permissaoExcluir, $rotaEditar, $rotaExcluir){
        $string = '<div class="d-flex align-items-center">';
        //Permissão editar
        if(\Auth::user()->can($permisaoAtualizar, $model)){
            $string .= '<a href="'. route($rotaEditar, [$model->id]).'" class="btn btn-sm btn-primary p-1" ><i class="fas fa-edit"></i> Editar</a>';
        }
        //Permissão excluir            
        if(\Auth::user()->can($permissaoExcluir, $model)){
            $string .= formExcluir($model, $rotaExcluir);
        }
        $string.='</div>';
        return $string;
    }
}

/** Retona o formulário HTML com o botão excluir 
 * 
 * @param Illuminate\Database\Eloquent\Model $model
 * @param string $rota
 * 
 * @return string
*/
if(!function_exists('formExcluir')){
    function formExcluir($model, $rota){
        $html = Form::open(array('route' => [$rota, $model->id], 'method' => 'DELETE', 'class' => 'delete p-1'));
        $html .= Form::button('<i class="far fa-trash-alt"></i> Excluir', [
            'type' => 'submit', 
            'data-toggle'=>'confirmation', 
            'class' => 'btn btn-sm btn-danger'
        ]);
        $html .= Form::close();
        return $html;
    }
}

/**
 * Valida permissão de usuário
 * 
 * @param string $nome
 * @return void
 */
if(!function_exists('checkPermissao')){
    function checkPermissao(string $nome)
    {
        if(\Gate::denies($nome)){
            abort(401);
        }
    }
}

/**
 * Dado um array de permissões válida se usuário possui pelo menos uma delas
 * 
 * @param array $permissoes
 * @return void
 */
if(!function_exists('checkPermissoes')){
    function checkPermissoes(array $permissoes)
    {
        $temPermissao = false;
        if(!\Auth::user()->eAdmin()){
            foreach ($permissoes as $permissao) {
                $temPermissao = \Auth::user()->hasRole($permissao);
                if($temPermissao) {
                    break;
                }
            }
        }else{
            $temPermissao = true;
        }

        if (!$temPermissao) {
            abort(401);
        }
    }
}
