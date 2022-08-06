<?php

namespace ControleAcesso\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use ControleAcesso\Models\User;

class UserFactory extends Factory
{

    /**
     * Tipo de objetos a serem fabricados
     * 
     * @var \ControleAcesso\Models\User
     */
    protected $model = User::class;

    /**
     * Forma para fabricar User
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->text(30),
            'username' => $this->faker->unique(10)->username,
            'email' => $this->faker->unique()->safeEmail,
            'password' => $this->faker->password(),
            'remember_token' => \Str::random(10),
        ];
    }    
}