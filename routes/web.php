<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\AutorController;
use App\Http\Controllers\LibroController;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/catalogo', function () {
    $libros = \App\Models\Libro::with(['autor', 'categoria'])
        ->when(request('categoria_id'), fn($q) => $q->where('categoria_id', request('categoria_id')))
        ->when(request('autor_id'), fn($q) => $q->where('autor_id', request('autor_id')))
        ->when(request('buscar'), fn($q) => $q->where('titulo', 'like', '%'.request('buscar').'%'))
        ->latest()->get();

    $categorias = \App\Models\Categoria::all();
    $autores = \App\Models\Autor::all();

    return view('catalogo', compact('libros', 'categorias', 'autores'));
})->name('catalogo');

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('categorias', CategoriaController::class);
    Route::resource('autores', AutorController::class);
    Route::resource('libros', LibroController::class);
    Route::get('/estructuras/catalogo-libros', [App\Http\Controllers\EstructuraController::class, 'listaEnlazada'])->name('estructuras.lista');
    Route::get('/estructuras/historial-libros', [App\Http\Controllers\EstructuraController::class, 'pila'])->name('estructuras.pila');
    Route::get('/estructuras/solicitudes-libros', [App\Http\Controllers\EstructuraController::class, 'cola'])->name('estructuras.cola');
    Route::get('/estructuras/busqueda-libros', [App\Http\Controllers\EstructuraController::class, 'arbolBinario'])->name('estructuras.arbol');
    Route::get('/estructuras/relacion-autores', [App\Http\Controllers\EstructuraController::class, 'grafo'])->name('estructuras.grafo');
});

Route::get('/dashboard', function () {
    return redirect()->route('libros.index');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';