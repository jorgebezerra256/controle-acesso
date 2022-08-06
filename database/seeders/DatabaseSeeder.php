<?php

namespace ControleAcesso\Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Popula o banco de dados com os seeds definidos
     *
     * @return void
     */
    public function run()
    {       
        $this->call(PermissaoTableSeeder::class);
        $this->call(PapelTableSeeder::class);
        
    }
}
