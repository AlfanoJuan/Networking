<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\InterestsController;
use App\Http\Controllers\ExposController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [WelcomeController::class, 'index']);

Route::get('cerrarSesion', [LoginController::class, 'logOut']
)->name('cerrarSesion')->middleware('logOut');


//Acceso todos inicio sesion
Route::resource('inicioSesion', LoginController::class, [
    //1. Vista inicio sesion
    'index' => 'inicioSesion.index',
    //2. Enviar request
    'store' => 'inicioSesion.store'
]);


Route::group(['middleware' => 'isAdmin'], function () {

    Route::resource('admin', AdminController::class, [
        //1. Vista principal de administrador (tab de estudiantes y empresas)
        'index' => 'admin.index',
    ]);

    Route::resource('adminEmpresa', CompanyController::class, [
        //1. Vista principal de registro empresa
        'create' => 'adminEmpresa.create',
        //2. Guardar
        'store' => 'adminEmpresa.store',
        //3. Vista para editar
        'edit' => 'adminEmpresa.edit',
        //4. Guardar editar
        'update' => 'adminEmpresa.update',
        //5. Eliminar
        'destroy' => 'adminEmpresa.destroy'
    ]);

    Route::resource('adminEstudiante', StudentController::class, [
        //1. Vista principal de registro estudiantes
        'create'    => 'adminEstudiante.create',
        //2. Guardar
        'store'     => 'adminEstudiante.store',
        //3. Vista para editar
        'edit'      => 'adminEstudiante.edit',
        //4. Guardar editar
        'update'    => 'adminEstudiante.update',
        //5. Eliminar
        'destroy'   => 'adminEstudiante.destroy'
    ]);

    Route::resource('adminInterests', InterestsController::class,[
        'index' => 'adminInterests.index',
        'show' => 'adminInterests.show',
        'create' => 'adminInterests.create',
        'store' => 'adminInterests.store',
        'destroy' => 'adminInterests.destroy',
    ]);

    Route::resource('adminExpo', ExposController::class,[
        'index' => 'adminExpo.index',
        'show' => 'adminExpo.show',
        'create' => 'adminExpo.create',
        'store' => 'adminExpo.store',
        'destroy' => 'adminExpo.destroy',
    ]);
});



Route::group(['middleware' => 'isCompany'], function () {

    Route::resource('empresa', CompanyController::class, [
        //1. Vista principal de empresa (cartas de estudiantes)
        'index' => 'empresa.index',
        //2. Vista perfil de una empresa
        'show' => 'empresa.show',
    ]);

    //3. Vista principal de un estudiante desde una empresa
    Route::get('empresaVeEstudiante/{id}', [StudentController::class, 'verEstudiante'])
    ->name('verEstudiante');

    //4. Cambiar redes
    Route::put('editarRe/{id}', [CompanyController::class, 'editarRedes'])
    ->name('editarRe');

    Route::put('editarPass/{id}', [CompanyController::class, 'editarPass'])
    ->name('editarPass');

});

Route::group(['middleware' => 'isStudent'], function () {

    Route::resource('estudiante', StudentController::class, [
        //1. Vista principal de un estudiante (cartas de empresas)
        'index' => 'estudiante.index',
        //2. Vista perfil de un estudiante
        'show' => 'estudiante.show',
    ]);

    //3. Vista principal una empresa desde un estudiante
    Route::get('estudianteVeEmpresa/{id}', [CompanyController::class, 'verEmpresa'])
        ->name('verEmpresa');

    //4. Cambiar foto de perfil
    Route::put('editarImagen/{id}', [StudentController::class, 'editarImagen'])
    ->name('editarImagen');
    
    //5. Cambiar contraseña
    Route::put('editarPassword/{id}', [StudentController::class, 'editarPassword'])
    ->name('editarPassword');

    //6. Cambiar redes
    Route::put('editarRedes/{id}', [StudentController::class, 'editarRedes'])
    ->name('editarRedes');
});
