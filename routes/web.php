<?php
/**
 * Rotas definidas neste projeto
 * 
 */


use ControleAcesso\Http\Controllers\{
  PapeisController,
  PermissoesController,
  UserController
};

Route::group(['middleware' => ['web', 'auth'], 'prefix' => 'admin'], function () {
  Route::prefix('usuarios')->group(function () {
    Route::get('/', [UserController::class, 'index'])
      ->name('users.index');
    Route::post('get_datatableUsuarios', [UserController::class, 'get_datatable']);

    Route::post('get_datatableUsuarioPapel/{user}', [UserController::class, 'get_datatableUsuarioPapel']);
    Route::get('papel/{id}', [UserController::class, 'papel'])
      ->name('users.papel');
    Route::post('papel/{id}', [UserController::class, 'papelStore'])
      ->name('users.papel.store');
    Route::delete('papel/{usuario}/{papel}', [UserController::class, 'papelDestroy'])
      ->name('users.papel.destroy');
  });

  Route::prefix('permissoes')->group(function(){
    Route::get('/', [PermissoesController::class, 'index'])
    ->name('permissoes.index');
    Route::get('create', [PermissoesController::class, 'create'])
    ->name('permissoes.create');
    Route::post('create/salvar', [PermissoesController::class, 'store'])
    ->name('permissoes.store');
    Route::get('edit/{id}', [PermissoesController::class, 'edit'])
    ->name('permissoes.edit');
    Route::put('update/{permissao}', [PermissoesController::class, 'update'])
    ->name('permissoes.update');
    Route::delete('exclude/{id}', [PermissoesController::class, 'destroy'])
    ->name('permissoes.destroy');

    Route::post('get_datatable', [PermissoesController::class, 'get_datatable']);
  });

  Route::prefix('papeis')->group(function () {
    Route::get('/', [PapeisController::class, 'index'])
      ->name('papeis.index');
    Route::get('create', [PapeisController::class, 'create'])
      ->name('papeis.create');
    Route::post('create/salvar', [PapeisController::class, 'store'])
      ->name('papeis.store');
    Route::get('edit/{id}', [PapeisController::class, 'edit'])
      ->name('papeis.edit');
    Route::put('update/{papel}', [PapeisController::class, 'update'])
      ->name('papeis.update');
    Route::delete('exclude/{id}', [PapeisController::class, 'destroy'])
      ->name('papeis.destroy');

    Route::post('get_datatablePapeis', [PapeisController::class, 'get_datatable']);

    Route::post('get_datatablePapelPermissao/{id}', [PapeisController::class, 'get_datatablePapelPermissao']);
    Route::get('permissao/{id}', [PapeisController::class, 'permissao'])
      ->name('papeis.permissao');
    Route::post('permissao/{permissao}', [PapeisController::class, 'permissaoStore'])
      ->name('papeis.permissao.store');
    Route::delete('permissao/{papel}/{permissao}', [PapeisController::class, 'permissaoDestroy'])
      ->name('papeis.permissao.destroy');
  });
});
