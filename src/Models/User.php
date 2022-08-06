<?php

namespace ControleAcesso\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use ControleAcesso\Models\Autorizacao;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use ControleAcesso\Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class User extends Authenticatable implements AuditableContract
{
    use Auditable,
    Autorizacao,
    HasFactory;    

    /**
     * Atributos do modelo para atribuição em massa
     *
     * @var string[]
     */
    protected $fillable = [
        'name', 'username', 'password', 'email', 'objectguid'
    ];

    /**
     * Atributos ocultos para arrays
     *
     * @var string[]
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Retorna primeiro nome do usuário
     * 
     * @return string
     */
    public function firstName()
    {
        $primeiroNome = explode(" ", $this->attributes['name']);
        return $primeiroNome[0];
    }
   
    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return UserFactory::new();
    }
}
