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

    // Insertar elemento en el tope
    public function push($dato)
    {
        $nuevo = new NodoPila($dato);
        $nuevo->siguiente = $this->tope;
        $this->tope = $nuevo;
        $this->tamanio++;
    }

    // Eliminar elemento del tope
    public function pop()
    {
        if ($this->estaVacia()) return null;
        $dato = $this->tope->dato;
        $this->tope = $this->tope->siguiente;
        $this->tamanio--;
        return $dato;
    }

    // Ver el tope sin eliminar
    public function peek()
    {
        if ($this->estaVacia()) return null;
        return $this->tope->dato;
    }

    // Recorrer todos los elementos
    public function recorrer()
    {
        $elementos = [];
        $actual = $this->tope;
        while ($actual !== null) {
            $elementos[] = $actual->dato;
            $actual = $actual->siguiente;
        }
        return $elementos;
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