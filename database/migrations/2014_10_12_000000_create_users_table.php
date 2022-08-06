<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Cria tabela users
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('username')
            ->unique();            
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
            $table->string('email', 255)->nullable();
            $table->string('objectguid')->unique()->nullable()->after('id');
        });
    }

    /**
     * Remove tabela users
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
