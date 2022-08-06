<?php

namespace ControleAcesso\Models;

use ControleAcesso\Models\Model;
use ControleAcesso\Database\Factories\PermissaoFactory;


class Permissao extends Model
{    
    /**
     * Nome da tabela referente a este model
     * 
     * @var string
     */
    protected $table = 'permissoes';

    /**
     * Atributos do modelo para atribuição em massa
     * 
     * @var string[]
     */
    protected $fillable = ['nome', 'descricao'];
        
    /**
     * Relacionamento muitos para muitos entre Papel e Permissao
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function papeis(){
        return $this->belongsToMany(Papel::class);
    }

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return PermissaoFactory::new();
    }
}
