<?php

namespace App\Http\Controllers;

use App\Models\Autor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
            'foto'         => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data = $request->only(['nombre', 'nacionalidad']);

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('autores', 'public');
        }

        Autor::create($data);
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
            'foto'         => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data = $request->only(['nombre', 'nacionalidad']);

        if ($request->hasFile('foto')) {
            if ($autor->foto) {
                Storage::disk('public')->delete($autor->foto);
            }
            $data['foto'] = $request->file('foto')->store('autores', 'public');
        }

        $autor->update($data);
        return redirect()->route('autores.index')
                         ->with('success', 'Autor actualizado correctamente.');
    }

    public function destroy(Autor $autor)
    {
        if ($autor->foto) {
            Storage::disk('public')->delete($autor->foto);
        }

        $autor->delete();
        return redirect()->route('autores.index')
                         ->with('success', 'Autor eliminado correctamente.');
    }
}