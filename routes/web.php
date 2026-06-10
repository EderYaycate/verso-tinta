<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\AutorController;
use App\Http\Controllers\LibroController;
use App\Http\Controllers\HomeController;

// Página principal pública
Route::get('/', function () {
    return view('home');
})->name('home');

// Página principal pública
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
    Route::get('/estructuras/lista-enlazada', [App\Http\Controllers\EstructuraController::class, 'listaEnlazada'])->name('estructuras.lista');
    Route::get('/estructuras/pila', [App\Http\Controllers\EstructuraController::class, 'pila'])->name('estructuras.pila');
    Route::get('/estructuras/cola', [App\Http\Controllers\EstructuraController::class, 'cola'])->name('estructuras.cola');
    Route::get('/estructuras/arbol-bst', [App\Http\Controllers\EstructuraController::class, 'arbolBST'])->name('estructuras.bst');
    Route::get('/estructuras/arbol-avl', [App\Http\Controllers\EstructuraController::class, 'arbolAVL'])->name('estructuras.avl');
});
    


// Dashboard después de login
Route::get('/dashboard', function () {
    return redirect()->route('libros.index');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';