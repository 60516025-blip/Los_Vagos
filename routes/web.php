<?php

use App\Http\Controllers\EstudianteController;
use App\Http\Controllers\NotaController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/estudiantes');

Route::resource('estudiantes', EstudianteController::class)
    ->only(['index', 'create', 'store', 'show', 'destroy']);

Route::post('estudiantes/{estudiante}/notas', [NotaController::class, 'store'])->name('notas.store');
Route::delete('notas/{nota}', [NotaController::class, 'destroy'])->name('notas.destroy');