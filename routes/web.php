<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\AutorController;
use App\Http\Controllers\LibroController;
use App\Http\Controllers\CarritoController;
use App\Http\Controllers\PedidoController;
use App\Models\User;

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
    Route::get('/estructuras/catalogo-libros/{id?}', [App\Http\Controllers\EstructuraController::class, 'listaEnlazada'])->name('estructuras.lista');
    Route::get('/estructuras/historial-compras', [App\Http\Controllers\EstructuraController::class, 'historialCompras'])->name('estructuras.historial');
    Route::get('/estructuras/busqueda-libros', [App\Http\Controllers\EstructuraController::class, 'arbolBinario'])->name('estructuras.arbol');
    Route::get('/estructuras/relacion-autores', [App\Http\Controllers\EstructuraController::class, 'grafo'])->name('estructuras.grafo');
    Route::get('/admin/pedidos', [PedidoController::class, 'adminIndex'])->name('admin.pedidos');
    Route::patch('/admin/pedidos/{pedido}', [PedidoController::class, 'adminActualizar'])->name('admin.pedidos.actualizar');
    Route::post('/autores/{id}/actualizar', [AutorController::class, 'actualizar'])->name('autores.actualizar');
    Route::get('/autores/{id}/actualizar-autor', [AutorController::class, 'editarAutor'])->name('autores.editarAutor');
    Route::post('/autores/{id}/actualizar-autor', [AutorController::class, 'guardarAutor'])->name('autores.guardarAutor');
    Route::post('/autores/{id}/eliminar', [AutorController::class, 'eliminarAutor'])->name('autores.eliminarAutor');
});

Route::middleware(['auth', 'role:usuario'])->group(function () {
    Route::get('/usuario/catalogo-libros/{id?}', [App\Http\Controllers\EstructuraController::class, 'listaEnlazadaUsuario'])->name('usuario.lista');
    Route::get('/usuario/ultimos-libros', [App\Http\Controllers\EstructuraController::class, 'pilaUsuario'])->name('usuario.pila');
    Route::get('/usuario/libros-en-orden', [App\Http\Controllers\EstructuraController::class, 'colaUsuario'])->name('usuario.cola');
    Route::get('/usuario/buscar-libros', [App\Http\Controllers\EstructuraController::class, 'arbolUsuario'])->name('usuario.arbol');
    Route::get('/usuario/autores-destacados', [App\Http\Controllers\EstructuraController::class, 'grafoUsuario'])->name('usuario.grafo');

    // Carrito
    Route::get('/carrito', [CarritoController::class, 'index'])->name('carrito.index');
    Route::post('/carrito/agregar', [CarritoController::class, 'agregar'])->name('carrito.agregar');
    Route::patch('/carrito/{carrito}', [CarritoController::class, 'actualizar'])->name('carrito.actualizar');
    Route::delete('/carrito/{carrito}', [CarritoController::class, 'eliminar'])->name('carrito.eliminar');

    // Pedidos
    Route::get('/checkout', [PedidoController::class, 'checkout'])->name('checkout');
    Route::post('/checkout/confirmar', [PedidoController::class, 'confirmar'])->name('pedidos.confirmar');
    Route::get('/mis-pedidos', [PedidoController::class, 'historial'])->name('pedidos.historial');
    Route::get('/mis-pedidos/{pedido}', [PedidoController::class, 'show'])->name('pedidos.show');
});

Route::get('/dashboard', function () {
    /** @var User $user */
    $user = Auth::user();

    if ($user->hasRole('admin')) {
        return redirect()->route('libros.index');
    }

    return redirect()->route('usuario.lista');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';