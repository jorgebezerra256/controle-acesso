<?php

namespace ControleAcesso\Tests;

use \Orchestra\Testbench\TestCase as BaseTestCase;
use ControleAcesso\Providers\ControleAcessoServiceProvider;
use Acacha\AdminLTETemplateLaravel\Providers\AdminLTETemplateServiceProvider;
use ControleAcesso\Models\Permissao;
use Collective\Html\HtmlServiceProvider;
// Executar migrações atomaticamente
use Illuminate\Foundation\Testing\RefreshDatabase;
// Ignorar autenticação nos testes
use Illuminate\Foundation\Testing\WithoutMiddleware;
// Testar componentes do blade
use Illuminate\Foundation\Testing\Concerns\InteractsWithViews;
use Yajra\DataTables\DataTablesServiceProvider;


abstract class TestCase extends BaseTestCase
{    
    use RefreshDatabase,
    WithoutMiddleware, //Ignorar autenticação
    InteractsWithViews; // Errors

    public function setUp() : void
    {
        parent::setUp();          
        // Carregar subpastas da pasta migration
        $mainPath = realpath(__DIR__.'/../database/migrations');
        $directories = glob($mainPath . '\*' , GLOB_ONLYDIR);
        $paths = array_merge([$mainPath], $directories);
                
        // Carrega as migrations do pacote para executar os testes
        $this->loadMigrationsFrom([
            '--database' => 'controle_acesso_database',
            '--path' => realpath(__DIR__.'/../database/migrations/'),
        ]);
                
    }

    protected function getPackageProviders($app)
    {
        
        return [
            ControleAcessoServiceProvider::class,
            AdminLTETemplateServiceProvider::class,
            HtmlServiceProvider::class,
            DataTablesServiceProvider::class
        ];
    }

    /**
     * Override application aliases.
     *
     * @param  \Illuminate\Foundation\Application  $app
     *
     * @return array
     */
    protected function getPackageAliases($app)
    {
        return [
            "Form" => "Collective\Html\FormFacade",
            "Html" => "Collective\Html\HtmlFacade"
        ];
    }

    
    protected function defineEnvironment($app)    
    {
        $sqlite = [
            'driver' => 'sqlite',
            'schema' => 'public',
            'database' => ':memory:',
            'prefix' => ''
        ];
                
        $app['config']->set('database.connections.controle_acesso_database', $sqlite);
        $app['config']->set('database.default', 'controle_acesso_database');
    } 

    protected function getApplicationTimezone($app)
    {
        return 'America/Cuiaba';
    }
        
}
