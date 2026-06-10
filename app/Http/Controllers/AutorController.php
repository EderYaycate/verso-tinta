<?php

namespace App\Http\Controllers;

use App\Models\Autor;
use Illuminate\Http\Request;

class AutorController extends Controller
{
    public function index()
    {
        $autores = Autor::withCount('libros')->get();
        return view('autores.index', compact('autores'));
    }

    public function create()
    {
        return view('autores.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre'       => 'required|string|max:255',
            'nacionalidad' => 'required|string|max:255',
        ]);

        Autor::create($request->all());
        return redirect()->route('autores.index')
                         ->with('success', 'Autor creado correctamente.');
    }

    public function show(Autor $autor)
    {
        $autor->load('libros');
        return view('autores.show', compact('autor'));
    }

    public function edit(Autor $autor)
    {
        return view('autores.edit', compact('autor'));
    }

    public function update(Request $request, Autor $autor)
    {
        $request->validate([
            'nombre'       => 'required|string|max:255',
            'nacionalidad' => 'required|string|max:255',
        ]);

        $autor->update($request->all());
        return redirect()->route('autores.index')
                         ->with('success', 'Autor actualizado correctamente.');
    }

    public function destroy(Autor $autor)
    {
        $autor->delete();
        return redirect()->route('autores.index')
                         ->with('success', 'Autor eliminado correctamente.');
    }
}