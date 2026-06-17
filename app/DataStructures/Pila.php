<?php

namespace App\DataStructures;

class NodoPila
{
    public $dato;
    public $siguiente;

    public function __construct($dato)
    {
        $this->dato = $dato;
        $this->siguiente = null;
    }
}

class Pila
{
    private $tope;
    private $tamanio;

    public function __construct()
    {
        $this->tope = null;
        $this->tamanio = 0;
    }

    public function push($dato)
    {
        $nuevo = new NodoPila($dato);
        $nuevo->siguiente = $this->tope;
        $this->tope = $nuevo;
        $this->tamanio++;
    }

    public function pop()
    {
        if ($this->estaVacia()) {
            return null;
        }
        $dato = $this->tope->dato;
        $this->tope = $this->tope->siguiente;
        $this->tamanio--;
        return $dato;
    }

    public function peek()
    {
        if ($this->estaVacia()) {
            return null;
        }
        return $this->tope->dato;
    }

    public function recorrer()
    {
        $elementos = [];
        $this->recorrerNodo($this->tope, $elementos);
        return $elementos;
    }

    private function recorrerNodo($nodo, &$elementos)
    {
        if ($nodo === null) {
            return;
        }
        $elementos[] = $nodo->dato;
        $this->recorrerNodo($nodo->siguiente, $elementos);
    }

    public function estaVacia()
    {
        return $this->tope === null;
    }

    public function tamanio()
    {
        return $this->tamanio;
    }
}