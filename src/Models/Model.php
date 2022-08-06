<?php

namespace ControleAcesso\Models;

use Illuminate\Database\Eloquent\Model as ModelLaravel;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;


abstract class Model extends ModelLaravel implements AuditableContract
{
    use HasFactory, Auditable;
      
    /**
     * Formata a data para serialização
     *
     * @param  \DateTimeInterface  $date
     * @return string
     */
    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}