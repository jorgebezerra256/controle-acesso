<?php

namespace ControleAcesso\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use ControleAcesso\Models\Permissao;

class PermissaoFactory extends Factory
{

    /**
     * Tipo de objetos a serem fabricados
     * 
     * @var \ControleAcesso\Models\Permissao
     */
    protected $model = Permissao::class;

    /**
     * Forma para fabricar objeto Permissao
     * 
     * @return array
     */
    public function definition()
    {
        return [
            'id'        => $this->faker->unique()->randomNumber(4),
            'nome'      => $this->faker->unique()->text(),
            'descricao' => $this->faker->text()
        ];
    }

    
}