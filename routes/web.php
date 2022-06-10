<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {

    if (auth()->user()) {
        if (auth()->user()->clv_tipo_usuario == 1) {
            return view('welcome');
        }

        if (auth()->user()->clv_tipo_usuario == 2) {
            return view('welcome');
        }

        if (auth()->user()->clv_tipo_usuario == 3) {
            return view('welcome');
        }

        if (auth()->user()->clv_tipo_usuario == 4) {
            return view('welcome');
        }
    }


    return view('welcome');
});


Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('welcome');
})->name('dashboard');


Route::group(['middleware' => ['auth:sanctum', 'verified', 'admin']], function () {

    Route::get('/inicio', function () {
        return view('admin-dashboard');
    })->name('admin-dashboard');

    Route::get('/tipo-usuario', function () {
        return view('View-tipo-usuario.view-tipo-usuario');
    })->name('tipo-usuario');

    Route::get('/usuarios', function () {
        return view('View-usuario.view-usuario');
    })->name('usuarios');

    Route::get('/materias', function () {
        return view('View-materia.view-materia');
    })->name('materias');
});




Route::group(['middleware' => ['auth:sanctum', 'verified', 'maestro']], function () {

    Route::get('/maestro', function () {
        return view('maestro-dashboard');
    })->name('maestro-dashboard');

    Route::get('/actividad', function () {
        return view('View-actividad.view-actividad');
    })->name('actividad');

    Route::get('/actividad-contenido/{id}', function ($id) {
        return view('View-act-contenido.view-act-contenido', [
            'datos' => $id,
        ]);
    })->name('actividad-contenido');

    Route::get('/asignar-actividad', function () {
        return view('View-asignar.view-asignar');
    })->name('asignar-actividad');

    Route::get('/vista-actividad/{id}', function ($id) {
        return view('View-vista-cat-maestro.view-vista-cat-maestro', [
            'datos' => $id,
        ]);
    })->name('vista-actividad');
    
});


Route::group(['middleware' => ['auth:sanctum', 'verified', 'alumno']], function () {

    Route::get('/alumno', function () {
        return view('alumno-dashboard');
    })->name('alumno-dashboard');

    Route::get('/alumno-actividades/{id}', function ($id) {
        return view('View-act-alumno.view-act-alumno', [
            'datos' => $id,
        ]);
    })->name('alumno-actividades');

    Route::get('/mis-cursos', function () {
        return view('View-alumno-cursos.view-alumno-cursos');
    })->name('mis-cursos');

    Route::get('/contesta-actividad/{id}', function ($id) {
        return view('View-contestar-actividad.view-contestar-actividad', [
            'datos' => $id,
        ]);
    })->name('contesta-actividad');
});



Route::group(['middleware' => ['auth:sanctum', 'verified', 'espera']], function () {

    Route::get('/espera', function () {
        return view('dashboard');
    })->name('dashboard');
});
