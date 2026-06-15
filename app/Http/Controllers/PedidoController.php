<?php

namespace App\Http\Controllers;

use App\Models\Carrito;
use App\Models\Pedido;
use App\Models\PedidoItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PedidoController extends Controller
{
    public function checkout()
    {
        $items = Carrito::with('libro')
            ->where('user_id', Auth::id())
            ->get();

        if ($items->isEmpty()) {
            return redirect()->route('carrito.index')
                ->with('error', 'Tu carrito está vacío.');
        }

        $total = $items->sum(fn($item) => $item->libro->precio * $item->cantidad);

        return view('usuario.checkout', compact('items', 'total'));
    }

    public function confirmar(Request $request)
    {
        $request->validate([
            'direccion'  => 'required|string|max:255',
            'referencia' => 'nullable|string|max:255',
            'telefono'   => 'required|string|max:20',
        ]);

        $items = Carrito::with('libro')
            ->where('user_id', Auth::id())
            ->get();

        if ($items->isEmpty()) {
            return redirect()->route('carrito.index')
                ->with('error', 'Tu carrito está vacío.');
        }

        $total = $items->sum(fn($item) => $item->libro->precio * $item->cantidad);

        DB::transaction(function () use ($request, $items, $total) {
            $pedido = Pedido::create([
                'user_id'    => Auth::id(),
                'direccion'  => $request->direccion,
                'referencia' => $request->referencia,
                'telefono'   => $request->telefono,
                'total'      => $total,
                'estado'     => 'pendiente',
            ]);

            foreach ($items as $item) {
                PedidoItem::create([
                    'pedido_id' => $pedido->id,
                    'libro_id'  => $item->libro_id,
                    'cantidad'  => $item->cantidad,
                    'precio'    => $item->libro->precio,
                ]);
            }

            Carrito::where('user_id', Auth::id())->delete();
        });

        return redirect()->route('pedidos.historial')
            ->with('success', '¡Pedido confirmado! Pronto nos comunicaremos contigo.');
    }

    public function historial()
    {
        $pedidos = Pedido::with('items.libro')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('usuario.pedidos', compact('pedidos'));
    }

    public function show(Pedido $pedido)
    {
        if ($pedido->user_id !== Auth::id()) {
            abort(403);
        }

        $pedido->load('items.libro.autor');

        return view('usuario.pedido-detalle', compact('pedido'));
    }

    // Admin
    public function adminIndex()
    {
        $pedidos = Pedido::with(['user', 'items'])
            ->latest()
            ->get();

        return view('estructuras.pedidos', compact('pedidos'));
    }

    public function adminActualizar(Request $request, Pedido $pedido)
    {
        $request->validate([
            'estado' => 'required|in:pendiente,confirmado,enviado,entregado',
        ]);

        $pedido->update(['estado' => $request->estado]);

        return back()->with('success', 'Estado del pedido actualizado.');
    }
}