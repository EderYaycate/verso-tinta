<?php

namespace App\Http\Controllers;

use App\Models\Carrito;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CarritoController extends Controller
{
    public function index()
    {
        $items = Carrito::with('libro.autor')
            ->where('user_id', Auth::id())
            ->get();

        $total = 0;
        $i = 0;
        while ($i < count($items)) {
            $total += $items[$i]->libro->precio * $items[$i]->cantidad;
            $i++;
        }

        return view('usuario.carrito', compact('items', 'total'));
    }

    public function agregar(Request $request)
    {
        $request->validate(['libro_id' => 'required|exists:libros,id']);

        $item = Carrito::where('user_id', Auth::id())
            ->where('libro_id', $request->libro_id)
            ->first();

        if ($item) {
            $item->increment('cantidad');
        } else {
            Carrito::create([
                'user_id'  => Auth::id(),
                'libro_id' => $request->libro_id,
                'cantidad' => 1,
            ]);
        }

        return back()->with('success', 'Libro agregado al carrito.');
    }

    public function actualizar(Request $request, Carrito $carrito)
    {
        $request->validate(['cantidad' => 'required|integer|min:1']);

        if ($carrito->user_id !== Auth::id()) {
            abort(403);
        }

        $carrito->update(['cantidad' => $request->cantidad]);

        return back()->with('success', 'Cantidad actualizada.');
    }

    public function eliminar(Carrito $carrito)
    {
        if ($carrito->user_id !== Auth::id()) {
            abort(403);
        }

        $carrito->delete();

        return back()->with('success', 'Libro eliminado del carrito.');
    }

    public function count()
    {
        return Carrito::where('user_id', Auth::id())->sum('cantidad');
    }
}