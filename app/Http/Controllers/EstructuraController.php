<?php

namespace App\Http\Controllers;

use App\Models\Libro;
use App\Models\Autor;
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

        // Agregar cada autor como vertice
        $i = 0;
        while ($i < count($autores)) {
            $grafo->agregarVertice($autores[$i]->nombre);
            $i++;
        }

        // Conectar autores que comparten la misma categoria
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

        $vertices = $grafo->obtenerVertices();
        $aristas  = $grafo->obtenerAristas();

        return view('estructuras.grafo', compact('vertices', 'aristas'));
    }
}