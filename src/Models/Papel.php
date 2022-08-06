<?php

namespace ControleAcesso\Models;

use ControleAcesso\Models\User;
use ControleAcesso\Models\Model;
use ControleAcesso\Database\Factories\PapelFactory;


class Papel extends Model
{
    /**
     * Nome da tabela refetente a este model
     * @var string
     */
    protected $table = 'papeis';

    /**
     * Atributos do model para atribuição em massa
     * 
     * @var string[]
     */
    protected $fillable = ['nome', 'descricao'];
       
    /**
     * Relação muitos para muitos ente Papel e User
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users(){
        return $this->belongsToMany(User::class);
    }

    /**
     * Relação muitos para muitos entre Papel e Permissao
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function permissoes(){
        return $this->belongsToMany(Permissao::class);
    }

    /**
     * Atribui permissão ao papel instanciado
     * 
     * @param string $permissao
     * @return void
     */
    public function adicionaPermissao($permissao){
        if(is_string($permissao)){
            $permissao = Permissao::where('nome', '=', $permissao)->firstOrFail();
        }

        if($this->existePermissao($permissao)){
            return;
        }

        $this->permissoes()->attach($permissao);
    }

    /**
     * Remove permissão do papel instanciado
     * 
     * @param string $permissao
     * @return int
     */
    public function removePermissao($permissao){
        if(is_string($permissao)){
            $permissao = Permissao::where('nome', '=', $permissao)->firstOrFail();
        }

        return $this->permissoes()->detach($permissao);
    }

    /**
     * Verifica se o papel possui a permissão informada
     * 
     * @param string $permissao
     * @return bool
     */
    public function existePermissao($permissao){
        if(is_string($permissao)){
            $permissao = Permissao::where('nome', '=', $permissao)->firstOrFail();
        }

        return (boolean) $this->permissoes()->find($permissao->id);
    }

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return PapelFactory::new();
    }
}
