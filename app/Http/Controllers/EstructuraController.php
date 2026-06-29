<?php

namespace App\Http\Controllers;

use App\Models\Libro;
use App\Models\Autor;
use App\Models\Categoria;
use App\Models\Pedido;
use App\DataStructures\ListaEnlazada;
use App\DataStructures\Pila;
use App\DataStructures\Cola;
use App\DataStructures\ArbolBinario;
use App\DataStructures\Grafo;

class EstructuraController extends Controller
{
    public function listaEnlazada()
    {
        $lista  = new ListaEnlazada();
        $libros = Libro::with(['autor', 'categoria'])->get();

        $i = 0;
        while ($i < count($libros)) {
            $lista->InsertarAlFinal([
                'id'        => $libros[$i]->id,
                'titulo'    => $libros[$i]->titulo,
                'autor'     => $libros[$i]->autor->nombre,
                'categoria' => $libros[$i]->categoria->nombre,
                'portada'   => $libros[$i]->portada,
            ]);
            $i++;
        }

        $elementos = $lista->recorrer();
        return view('estructuras.lista-enlazada', compact('elementos'));
    }

    public function pila()
    {
        $pila   = new Pila();
        $libros = Libro::with('autor')->latest()->take(8)->get();

        $i = 0;
        while ($i < count($libros)) {
            $pila->Apilar([
                'id'      => $libros[$i]->id,
                'titulo'  => $libros[$i]->titulo,
                'autor'   => $libros[$i]->autor->nombre,
                'portada' => $libros[$i]->portada,
            ]);
            $i++;
        }

        $elementos = $pila->recorrer();
        return view('estructuras.pila', compact('elementos'));
    }

    public function cola()
    {
        $cola   = new Cola();
        $libros = Libro::with('autor')->get();

        $i = 0;
        while ($i < count($libros)) {
            $cola->Encolar([
                'id'      => $libros[$i]->id,
                'titulo'  => $libros[$i]->titulo,
                'autor'   => $libros[$i]->autor->nombre,
                'portada' => $libros[$i]->portada,
            ]);
            $i++;
        }

        $elementos = $cola->recorrer();
        return view('estructuras.cola', compact('elementos'));
    }

    public function arbolBinario()
    {
        $arbol  = new ArbolBinario();
        $libros = Libro::with('autor')->get();

        $i = 0;
        while ($i < count($libros)) {
            $arbol->AñadirNodo([
                'id'      => $libros[$i]->id,
                'titulo'  => $libros[$i]->titulo,
                'autor'   => $libros[$i]->autor->nombre,
                'portada' => $libros[$i]->portada,
                'precio'  => $libros[$i]->precio,
            ]);
            $i++;
        }

        $inorden   = $arbol->InOrden();
        $preorden  = $arbol->PreOrden();
        $postorden = $arbol->PostOrden();

        return view('estructuras.arbol-binario', compact('inorden', 'preorden', 'postorden'));
    }

    public function grafo()
    {
        $grafo   = new Grafo();
        $autores = Autor::with(['libros.categoria'])->get();
        $this->construirGrafo($grafo, $autores);

        $vertices      = array_values($grafo->ObtenerVertices());
        $aristas       = $grafo->ObtenerAristas();
        $fotosAutores  = [];
        $idsAutores    = [];
        $librosAutores = [];

        $i = 0;
        while ($i < count($autores)) {
            $fotosAutores[$autores[$i]->nombre]  = $autores[$i]->foto;
            $idsAutores[$autores[$i]->nombre]    = $autores[$i]->id;
            $librosAutores[$autores[$i]->nombre] = [
                'biografia' => $autores[$i]->biografia,
                'libros'    => $autores[$i]->libros->map(function($l) {
                    return [
                        'titulo'  => $l->titulo,
                        'portada' => $l->portada,
                    ];
                })->toArray(),
            ];
            $i++;
        }

        return view('estructuras.grafo', compact('vertices', 'aristas', 'fotosAutores', 'idsAutores', 'librosAutores'));
    }

    public function historialCompras()
    {
        $pila    = new Pila();
        $pedidos = Pedido::with(['items.libro', 'user'])->latest()->get();

        $porFecha = [];
        $i = 0;
        while ($i < count($pedidos)) {
            $fecha = $pedidos[$i]->created_at->format('d/m/Y');
            if (!isset($porFecha[$fecha])) {
                $porFecha[$fecha] = ['total' => 0, 'pedidos' => 0, 'libros' => []];
            }
            $porFecha[$fecha]['total']   += $pedidos[$i]->total;
            $porFecha[$fecha]['pedidos'] += 1;

            $items = $pedidos[$i]->items;
            $j = 0;
            while ($j < count($items)) {
                $titulo = $items[$j]->libro->titulo;
                if (!isset($porFecha[$fecha]['libros'][$titulo])) {
                    $porFecha[$fecha]['libros'][$titulo] = 0;
                }
                $porFecha[$fecha]['libros'][$titulo] += $items[$j]->cantidad;
                $j++;
            }
            $i++;
        }

        $fechas = array_keys($porFecha);
        $k = 0;
        while ($k < count($fechas)) {
            $fecha  = $fechas[$k];
            $datos  = $porFecha[$fecha];
            arsort($datos['libros']);
            $masVendido = count($datos['libros']) > 0 ? array_key_first($datos['libros']) : 'Sin datos';
            $pila->Apilar([
                'fecha'       => $fecha,
                'total'       => $datos['total'],
                'pedidos'     => $datos['pedidos'],
                'mas_vendido' => $masVendido,
                'libros'      => $datos['libros'],
            ]);
            $k++;
        }

        $elementos = $pila->recorrer();
        return view('estructuras.historial-compras', compact('elementos'));
    }

    public function listaEnlazadaUsuario()
    {
        $query = Libro::with(['autor', 'categoria']);

        if (request('buscar')) {
            $query->where('titulo', 'like', '%' . request('buscar') . '%');
        }
        if (request('categoria_id')) {
            $query->where('categoria_id', request('categoria_id'));
        }
        if (request('autor_id')) {
            $query->where('autor_id', request('autor_id'));
        }

        $libros = $query->get();
        $lista  = new ListaEnlazada();

        $i = 0;
        while ($i < count($libros)) {
            $lista->InsertarAlFinal([
                'id'        => $libros[$i]->id,
                'titulo'    => $libros[$i]->titulo,
                'autor'     => $libros[$i]->autor->nombre,
                'categoria' => $libros[$i]->categoria->nombre,
                'portada'   => $libros[$i]->portada,
                'resumen'   => $libros[$i]->resumen,
                'precio'    => $libros[$i]->precio,
            ]);
            $i++;
        }

        $elementos  = $lista->recorrer();
        $categorias = Categoria::all();
        $autores    = Autor::all();

        return view('usuario.lista-enlazada', compact('elementos', 'categorias', 'autores'));
    }

    public function pilaUsuario()
    {
        $pila   = new Pila();
        $libros = Libro::with('autor')->latest()->take(8)->get();

        $i = 0;
        while ($i < count($libros)) {
            $pila->Apilar([
                'id'      => $libros[$i]->id,
                'titulo'  => $libros[$i]->titulo,
                'autor'   => $libros[$i]->autor->nombre,
                'portada' => $libros[$i]->portada,
            ]);
            $i++;
        }

        $elementos = $pila->recorrer();
        return view('usuario.pila', compact('elementos'));
    }

    public function colaUsuario()
    {
        $cola   = new Cola();
        $libros = Libro::with('autor')->get();

        $i = 0;
        while ($i < count($libros)) {
            $cola->Encolar([
                'id'      => $libros[$i]->id,
                'titulo'  => $libros[$i]->titulo,
                'autor'   => $libros[$i]->autor->nombre,
                'portada' => $libros[$i]->portada,
            ]);
            $i++;
        }

        $elementos = $cola->recorrer();
        return view('usuario.cola', compact('elementos'));
    }

    public function arbolUsuario()
    {
        $arbol  = new ArbolBinario();
        $libros = Libro::with('autor')->get();

        $i = 0;
        while ($i < count($libros)) {
            $arbol->AñadirNodo([
                'id'      => $libros[$i]->id,
                'titulo'  => $libros[$i]->titulo,
                'autor'   => $libros[$i]->autor->nombre,
                'portada' => $libros[$i]->portada,
                'precio'  => $libros[$i]->precio,
            ]);
            $i++;
        }

        $min = request('precio_min', 0);
        $max = request('precio_max', 9999);

        if (request('precio_min') || request('precio_max')) {
            $inorden = $arbol->BuscarPorRango($min, $max);
        } else {
            $inorden = $arbol->InOrden();
        }

        return view('usuario.arbol', compact('inorden'));
    }

    public function grafoUsuario()
    {
        $grafo   = new Grafo();
        $autores = Autor::with(['libros.categoria'])->get();
        $this->construirGrafo($grafo, $autores);

        $vertices      = array_values($grafo->ObtenerVertices());
        $aristas       = $grafo->ObtenerAristas();
        $fotosAutores  = [];
        $librosAutores = [];

        $i = 0;
        while ($i < count($autores)) {
            $fotosAutores[$autores[$i]->nombre]  = $autores[$i]->foto;
            $librosAutores[$autores[$i]->nombre] = [
                'biografia' => $autores[$i]->biografia,
                'libros'    => $autores[$i]->libros->map(function($l) {
                    return [
                        'titulo'  => $l->titulo,
                        'portada' => $l->portada,
                    ];
                })->toArray(),
            ];
            $i++;
        }

        return view('usuario.grafo', compact('vertices', 'aristas', 'fotosAutores', 'librosAutores'));
    }

    private function construirGrafo(Grafo $grafo, $autores)
    {
        $i = 0;
        while ($i < count($autores)) {
            $grafo->AgregarVertice($autores[$i]->nombre);
            $i++;
        }

        $i = 0;
        while ($i < count($autores)) {
            $categoriasA = array_values(
                $autores[$i]->libros->pluck('categoria.nombre')->unique()->toArray()
            );
            $this->conectarConSiguientes($grafo, $autores, $categoriasA, $i, $i + 1);
            $i++;
        }
    }

    private function conectarConSiguientes(Grafo $grafo, $autores, $categoriasA, $i, $j)
    {
        if ($j >= count($autores)) {
            return;
        }

        $categoriasB = array_values(
            $autores[$j]->libros->pluck('categoria.nombre')->unique()->toArray()
        );
        $this->compararCategorias($grafo, $autores[$i]->nombre, $autores[$j]->nombre, $categoriasA, $categoriasB, 0, 0);
        $this->conectarConSiguientes($grafo, $autores, $categoriasA, $i, $j + 1);
    }

    private function compararCategorias(Grafo $grafo, $nombreA, $nombreB, $catA, $catB, $k, $l)
    {
        $catA = array_values($catA);
        $catB = array_values($catB);

        if ($k >= count($catA)) {
            return;
        }
        if ($l >= count($catB)) {
            $this->compararCategorias($grafo, $nombreA, $nombreB, $catA, $catB, $k + 1, 0);
            return;
        }

        if ($catA[$k] === $catB[$l]) {
            $grafo->AgregarArista($nombreA, $nombreB, $catA[$k]);
        }

        $this->compararCategorias($grafo, $nombreA, $nombreB, $catA, $catB, $k, $l + 1);
    }
}