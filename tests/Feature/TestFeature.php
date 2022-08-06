<?php

namespace ControleAcesso\Tests\Feature;

use ControleAcesso\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use ControleAcesso\Models\User;
use ControleAcesso\Tests\Concerns\ComSessao;

class TestFeature extends TestCase
{
    use RefreshDatabase,
    ComSessao;

    public function setUp() : void
    {
        parent::setUp();
        // Ignorar autenticação
        // $this->withoutMiddleware();
        // Ignorar mix-manifest
        $this->withoutMix();
    }
    
}