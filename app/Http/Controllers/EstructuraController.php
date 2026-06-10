<?php

namespace App\Http\Controllers;

use App\Models\Libro;
use App\DataStructures\ListaEnlazada;
use App\DataStructures\Pila;
use App\DataStructures\Cola;
use App\DataStructures\ArbolBST;
use App\DataStructures\ArbolAVL;

class EstructuraController extends Controller
{
    // Lista Enlazada - Lista de libros disponibles
    public function listaEnlazada()
    {
        $lista = new ListaEnlazada();
        $libros = Libro::with(['autor', 'categoria'])->get();

        foreach ($libros as $libro) {
            $lista->insertar([
                'id'        => $libro->id,
                'titulo'    => $libro->titulo,
                'autor'     => $libro->autor->nombre,
                'categoria' => $libro->categoria->nombre,
                'portada'   => $libro->portada,
            ]);
        }

        $elementos = $lista->recorrer();
        return view('estructuras.lista-enlazada', compact('elementos'));
    }

    // Pila - Historial de libros visitados
    public function pila()
    {
        $pila = new Pila();
        $libros = Libro::with('autor')->latest()->take(8)->get();

        foreach ($libros as $libro) {
            $pila->push([
                'id'     => $libro->id,
                'titulo' => $libro->titulo,
                'autor'  => $libro->autor->nombre,
                'portada' => $libro->portada,
            ]);
        }

        $elementos = $pila->recorrer();
        return view('estructuras.pila', compact('elementos'));
    }

    // Cola - Cola de solicitudes de libros
    public function cola()
    {
        $cola = new Cola();
        $libros = Libro::with('autor')->get();

        foreach ($libros as $libro) {
            $cola->encolar([
                'id'     => $libro->id,
                'titulo' => $libro->titulo,
                'autor'  => $libro->autor->nombre,
                'portada' => $libro->portada,
            ]);
        }

        $elementos = $cola->recorrer();
        return view('estructuras.cola', compact('elementos'));
    }

    // Arbol BST - Busqueda de libros por titulo
    public function arbolBST()
    {
        $arbol = new ArbolBST();
        $libros = Libro::with('autor')->get();

        foreach ($libros as $libro) {
            $arbol->insertar([
                'id'      => $libro->id,
                'titulo'  => $libro->titulo,
                'autor'   => $libro->autor->nombre,
                'portada' => $libro->portada,
            ]);
        }

        $inorden   = $arbol->inorden();
        $preorden  = $arbol->preorden();
        $postorden = $arbol->postorden();

        return view('estructuras.arbol-bst', compact('inorden', 'preorden', 'postorden'));
    }

    // Arbol AVL - Busqueda de libros por autor
    public function arbolAVL()
    {
        $arbol = new ArbolAVL();
        $libros = Libro::with('autor')->get();

        foreach ($libros as $libro) {
            $arbol->insertar([
                'id'      => $libro->id,
                'titulo'  => $libro->titulo,
                'autor'   => $libro->autor->nombre,
                'portada' => $libro->portada,
            ]);
        }

        $elementos = $arbol->inorden();
        return view('estructuras.arbol-avl', compact('elementos'));
    }
}