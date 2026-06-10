<?php

namespace App\DataStructures;

class NodoCola
{
    public $dato;
    public $siguiente;

    public function __construct($dato)
    {
        $this->dato = $dato;
        $this->siguiente = null;
    }
}

class Cola
{
    private $frente;
    private $final;
    private $tamanio;

    public function __construct()
    {
        $this->frente = null;
        $this->final = null;
        $this->tamanio = 0;
    }

    // Insertar elemento al final
    public function encolar($dato)
    {
        $nuevo = new NodoCola($dato);
        if ($this->estaVacia()) {
            $this->frente = $nuevo;
            $this->final = $nuevo;
        } else {
            $this->final->siguiente = $nuevo;
            $this->final = $nuevo;
        }
        $this->tamanio++;
    }

    // Eliminar elemento del frente
    public function desencolar()
    {
        if ($this->estaVacia()) return null;
        $dato = $this->frente->dato;
        $this->frente = $this->frente->siguiente;
        if ($this->frente === null) {
            $this->final = null;
        }
        $this->tamanio--;
        return $dato;
    }

    // Ver el frente sin eliminar
    public function frente()
    {
        if ($this->estaVacia()) return null;
        return $this->frente->dato;
    }

    // Recorrer todos los elementos
    public function recorrer()
    {
        $elementos = [];
        $actual = $this->frente;
        while ($actual !== null) {
            $elementos[] = $actual->dato;
            $actual = $actual->siguiente;
        }
        return $elementos;
    }

    public function estaVacia()
    {
        return $this->frente === null;
    }

    public function tamanio()
    {
        return $this->tamanio;
    }
}