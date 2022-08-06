<?php

namespace ControleAcesso\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use ControleAcesso\Models\Papel;

class PapelFactory extends Factory
{

    /**
     * Tipo de objetos a serem fabricados
     * 
     * @var \ControleAcesso\Models\Papel
     */
    protected $model = Papel::class;

    /**
     * Forma para fabricar objeto Papel
     * 
     * @return array
     */
    public function definition()
    {
        return [
            'id'        => $this->faker->unique()->randomNumber(3),
            'nome'      => $this->faker->text(),
            'descricao' => $this->faker->text()
        ];
    }

    
}