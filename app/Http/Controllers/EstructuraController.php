<?php

namespace App\Http\Controllers;

use App\Models\Libro;
use App\Models\Autor;
use App\Models\Categoria;
use App\DataStructures\ListaEnlazada;
use App\DataStructures\Pila;
use App\DataStructures\Cola;
use App\DataStructures\ArbolBinario;
use App\DataStructures\Grafo;

class EstructuraController extends Controller
{
    public function listaEnlazada()
    {
        $lista = new ListaEnlazada();
        $libros = Libro::with(['autor', 'categoria'])->get();

        $i = 0;
        while ($i < count($libros)) {
            $lista->insertar([
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
        $pila = new Pila();
        $libros = Libro::with('autor')->latest()->take(8)->get();

        $i = 0;
        while ($i < count($libros)) {
            $pila->push([
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
        $cola = new Cola();
        $libros = Libro::with('autor')->get();

        $i = 0;
        while ($i < count($libros)) {
            $cola->encolar([
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
        $arbol = new ArbolBinario();
        $libros = Libro::with('autor')->get();

        $i = 0;
        while ($i < count($libros)) {
            $arbol->insertar([
                'id'      => $libros[$i]->id,
                'titulo'  => $libros[$i]->titulo,
                'autor'   => $libros[$i]->autor->nombre,
                'portada' => $libros[$i]->portada,
            ]);
            $i++;
        }

        $inorden   = $arbol->inorden();
        $preorden  = $arbol->preorden();
        $postorden = $arbol->postorden();

        return view('estructuras.arbol-binario', compact('inorden', 'preorden', 'postorden'));
    }

    public function grafo()
    {
        $grafo = new Grafo();
        $autores = Autor::with(['libros.categoria'])->get();

        $i = 0;
        while ($i < count($autores)) {
            $grafo->agregarVertice($autores[$i]->nombre);
            $i++;
        }

        $i = 0;
        while ($i < count($autores)) {
            $j = $i + 1;
            while ($j < count($autores)) {
                $categoriasA = $autores[$i]->libros->pluck('categoria.nombre')->unique()->toArray();
                $categoriasB = $autores[$j]->libros->pluck('categoria.nombre')->unique()->toArray();

                $k = 0;
                while ($k < count($categoriasA)) {
                    $l = 0;
                    while ($l < count($categoriasB)) {
                        if ($categoriasA[$k] === $categoriasB[$l]) {
                            $grafo->agregarArista(
                                $autores[$i]->nombre,
                                $autores[$j]->nombre,
                                $categoriasA[$k]
                            );
                        }
                        $l++;
                    }
                    $k++;
                }
                $j++;
            }
            $i++;
        }

        $vertices = array_values($grafo->obtenerVertices());
        $aristas  = $grafo->obtenerAristas();

        return view('estructuras.grafo', compact('vertices', 'aristas'));
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
        $lista = new ListaEnlazada();

        $i = 0;
        while ($i < count($libros)) {
            $lista->insertar([
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
        $pila = new Pila();
        $libros = Libro::with('autor')->latest()->take(8)->get();

        $i = 0;
        while ($i < count($libros)) {
            $pila->push([
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
        $cola = new Cola();
        $libros = Libro::with('autor')->get();

        $i = 0;
        while ($i < count($libros)) {
            $cola->encolar([
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
        $arbol = new ArbolBinario();
        $libros = Libro::with('autor')->get();

        $i = 0;
        while ($i < count($libros)) {
            $arbol->insertar([
                'id'      => $libros[$i]->id,
                'titulo'  => $libros[$i]->titulo,
                'autor'   => $libros[$i]->autor->nombre,
                'portada' => $libros[$i]->portada,
            ]);
            $i++;
        }

        $inorden = $arbol->inorden();
        return view('usuario.arbol', compact('inorden'));
    }

    public function grafoUsuario()
    {
        $grafo = new Grafo();
        $autores = Autor::with(['libros.categoria'])->get();

        $i = 0;
        while ($i < count($autores)) {
            $grafo->agregarVertice($autores[$i]->nombre);
            $i++;
        }

        $i = 0;
        while ($i < count($autores)) {
            $j = $i + 1;
            while ($j < count($autores)) {
                $categoriasA = $autores[$i]->libros->pluck('categoria.nombre')->unique()->toArray();
                $categoriasB = $autores[$j]->libros->pluck('categoria.nombre')->unique()->toArray();

                $k = 0;
                while ($k < count($categoriasA)) {
                    $l = 0;
                    while ($l < count($categoriasB)) {
                        if ($categoriasA[$k] === $categoriasB[$l]) {
                            $grafo->agregarArista(
                                $autores[$i]->nombre,
                                $autores[$j]->nombre,
                                $categoriasA[$k]
                            );
                        }
                        $l++;
                    }
                    $k++;
                }
                $j++;
            }
            $i++;
        }

        $vertices = array_values($grafo->obtenerVertices());
        $aristas  = $grafo->obtenerAristas();

        return view('usuario.grafo', compact('vertices', 'aristas'));
    }
}