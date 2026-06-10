<?php

namespace App\DataStructures;

class NodoBST
{
    public $dato;
    public $izquierdo;
    public $derecho;

    public function __construct($dato)
    {
        $this->dato = $dato;
        $this->izquierdo = null;
        $this->derecho = null;
    }
}

class ArbolBST
{
    private $raiz;

    public function __construct()
    {
        $this->raiz = null;
    }

    // Insertar un libro por titulo
    public function insertar($dato)
    {
        $this->raiz = $this->insertarNodo($this->raiz, $dato);
    }

    private function insertarNodo($nodo, $dato)
    {
        if ($nodo === null) {
            return new NodoBST($dato);
        }

        if ($dato['titulo'] < $nodo->dato['titulo']) {
            $nodo->izquierdo = $this->insertarNodo($nodo->izquierdo, $dato);
        } elseif ($dato['titulo'] > $nodo->dato['titulo']) {
            $nodo->derecho = $this->insertarNodo($nodo->derecho, $dato);
        }

        return $nodo;
    }

    // Buscar por titulo
    public function buscar($titulo)
    {
        return $this->buscarNodo($this->raiz, $titulo);
    }

    private function buscarNodo($nodo, $titulo)
    {
        if ($nodo === null) return null;

        if ($titulo === $nodo->dato['titulo']) {
            return $nodo->dato;
        }

        if ($titulo < $nodo->dato['titulo']) {
            return $this->buscarNodo($nodo->izquierdo, $titulo);
        }

        return $this->buscarNodo($nodo->derecho, $titulo);
    }

    // Eliminar por titulo
    public function eliminar($titulo)
    {
        $this->raiz = $this->eliminarNodo($this->raiz, $titulo);
    }

    private function eliminarNodo($nodo, $titulo)
    {
        if ($nodo === null) return null;

        if ($titulo < $nodo->dato['titulo']) {
            $nodo->izquierdo = $this->eliminarNodo($nodo->izquierdo, $titulo);
        } elseif ($titulo > $nodo->dato['titulo']) {
            $nodo->derecho = $this->eliminarNodo($nodo->derecho, $titulo);
        } else {
            if ($nodo->izquierdo === null) return $nodo->derecho;
            if ($nodo->derecho === null) return $nodo->izquierdo;

            $minimo = $this->minimoNodo($nodo->derecho);
            $nodo->dato = $minimo->dato;
            $nodo->derecho = $this->eliminarNodo($nodo->derecho, $minimo->dato['titulo']);
        }

        return $nodo;
    }

    private function minimoNodo($nodo)
    {
        while ($nodo->izquierdo !== null) {
            $nodo = $nodo->izquierdo;
        }
        return $nodo;
    }

    // Recorrido inorden (devuelve libros ordenados por titulo)
    public function inorden()
    {
        $resultado = [];
        $this->inordenRecursivo($this->raiz, $resultado);
        return $resultado;
    }

    private function inordenRecursivo($nodo, &$resultado)
    {
        if ($nodo === null) return;
        $this->inordenRecursivo($nodo->izquierdo, $resultado);
        $resultado[] = $nodo->dato;
        $this->inordenRecursivo($nodo->derecho, $resultado);
    }

    // Recorrido preorden
    public function preorden()
    {
        $resultado = [];
        $this->preordenRecursivo($this->raiz, $resultado);
        return $resultado;
    }

    private function preordenRecursivo($nodo, &$resultado)
    {
        if ($nodo === null) return;
        $resultado[] = $nodo->dato;
        $this->preordenRecursivo($nodo->izquierdo, $resultado);
        $this->preordenRecursivo($nodo->derecho, $resultado);
    }

    // Recorrido postorden
    public function postorden()
    {
        $resultado = [];
        $this->postordenRecursivo($this->raiz, $resultado);
        return $resultado;
    }

    private function postordenRecursivo($nodo, &$resultado)
    {
        if ($nodo === null) return;
        $this->postordenRecursivo($nodo->izquierdo, $resultado);
        $this->postordenRecursivo($nodo->derecho, $resultado);
        $resultado[] = $nodo->dato;
    }
}