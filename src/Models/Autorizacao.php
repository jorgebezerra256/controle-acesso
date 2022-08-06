<?php

namespace ControleAcesso\Models;


trait Autorizacao
{
    /**
     * Relacionamento muitos para muitos entre Papel e Permissao
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function papeis(){
        return $this->belongsToMany(Papel::class);
    }

    /**
     * Verifica se a instância atual é administrador
     * 
     * @return bool
     */
    public function eAdmin(){
        return $this->existePapel('Admin');
    }

    /**
     * Atribui papel a instâcia atual
     * 
     * @param string $papel
     * @return void
     */
    public function adicionaPapel($papel){
        if(is_string($papel)){
            $papel = Papel::where('nome', '=', $papel)->firstOrFail();
        }

        if($this->existePapel($papel)){
            return;
        }

        $this->papeis()->attach($papel);
    }

    /**
     * Remove papel da instância atual
     * 
     * @param string $papel
     * @return int
     */
    public function removePapel($papel){
        if(is_string($papel)){
            $papel = Papel::where('nome', '=', $papel)->firstOrFail();
        }

        return $this->papeis()->detach($papel);
    }

    /**
     * Verifica se um papel já existe no sistema
     * 
     * @param string $papel
     * @return bool
     */
    public function existePapel($papel){
        if(is_string($papel)){
            $papel = Papel::where('nome', '=', $papel)->firstOrFail();
        }

        return (boolean) $this->papeis->find($papel->id);
    }

    /**
     * Verifica se a instancia (usuário) tem um dos papeis informados
     * 
     * @param string
     * @return int
     */
    public function temUmPapelDestes($papeis){                
        $userPapeis = $this->papeis;
        return $papeis->intersect($userPapeis)->count();
    }
   
    /**
     * Verifica se a instância (usuário) tem o papel passado por parâmetro
     * 
     * @param string $papel
     * @return bool
     */
    public function hasRole(string $papel) : bool {
        return $this->papeis()->where('nome', $papel)->first() ? true : false;
    }
    
}
