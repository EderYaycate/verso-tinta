<?php

namespace App\Http\Controllers;

use App\Models\Libro;
use App\Models\Autor;
use App\Models\Categoria;
use App\Models\Carrito;
use App\Models\PedidoItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LibroController extends Controller
{
    public function index()
    {
        $libros = Libro::with(['autor', 'categoria'])->get();
        return view('libros.index', compact('libros'));
    }

    public function create()
    {
        $autores    = Autor::all();
        $categorias = Categoria::all();
        return view('libros.create', compact('autores', 'categorias'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'titulo'       => 'required|string|max:255',
            'resumen'      => 'required|string',
            'precio'       => 'required|numeric|min:0',
            'portada'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'autor_id'     => 'required|exists:autores,id',
            'categoria_id' => 'required|exists:categorias,id',
        ]);

        $data = $request->only(['titulo', 'resumen', 'precio', 'autor_id', 'categoria_id']);

        if ($request->hasFile('portada')) {
            $data['portada'] = $request->file('portada')->store('portadas', 'public');
        }

        Libro::create($data);
        return redirect()->route('libros.index')
                         ->with('success', 'Libro creado correctamente.');
    }

    public function show(Libro $libro)
    {
        return view('libros.show', compact('libro'));
    }

    public function edit(Libro $libro)
    {
        $autores    = Autor::all();
        $categorias = Categoria::all();
        return view('libros.edit', compact('libro', 'autores', 'categorias'));
    }

    public function update(Request $request, Libro $libro)
    {
        $request->validate([
            'titulo'       => 'required|string|max:255',
            'resumen'      => 'required|string',
            'precio'       => 'required|numeric|min:0',
            'portada'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'autor_id'     => 'required|exists:autores,id',
            'categoria_id' => 'required|exists:categorias,id',
        ]);

        $data = $request->only(['titulo', 'resumen', 'precio', 'autor_id', 'categoria_id']);

        if ($request->hasFile('portada')) {
            if ($libro->portada) {
                Storage::disk('public')->delete($libro->portada);
            }
            $data['portada'] = $request->file('portada')->store('portadas', 'public');
        }

        $libro->update($data);
        return redirect()->route('libros.index')
                         ->with('success', 'Libro actualizado correctamente.');
    }

    public function destroy(Libro $libro)
    {
        // Verificar si el libro está en algún carrito
        if (Carrito::where('libro_id', $libro->id)->exists()) {
            return redirect()->route('libros.index')
                ->with('error', 'No se puede eliminar el libro porque está en el carrito de un usuario.');
        }

        // Verificar si el libro está en algún pedido
        if (PedidoItem::where('libro_id', $libro->id)->exists()) {
            return redirect()->route('libros.index')
                ->with('error', 'No se puede eliminar el libro porque forma parte de un pedido.');
        }

        if ($libro->portada) {
            Storage::disk('public')->delete($libro->portada);
        }

        $libro->delete();
        return redirect()->route('libros.index')
                         ->with('success', 'Libro eliminado correctamente.');
    }
}