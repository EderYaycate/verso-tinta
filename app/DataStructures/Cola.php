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

    public function desencolar()
    {
        if ($this->estaVacia()) {
            return null;
        }
        $dato = $this->frente->dato;
        $this->frente = $this->frente->siguiente;
        if ($this->frente === null) {
            $this->final = null;
        }
        $this->tamanio--;
        return $dato;
    }

    public function frente()
    {
        if ($this->estaVacia()) {
            return null;
        }
        return $this->frente->dato;
    }

    public function recorrer()
    {
        $elementos = [];
        $this->recorrerNodo($this->frente, $elementos);
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
        return $this->frente === null;
    }

    public function tamanio()
    {
        return $this->tamanio;
    }
}

class NodoColaPrioridad
{
    public $dato;
    public $prioridad;
    public $siguiente;

    public function __construct($dato, $prioridad)
    {
        $this->dato      = $dato;
        $this->prioridad = $prioridad;
        $this->siguiente = null;
    }
}

class ColaPrioridad
{
    private $frente;
    private $tamanio;

    public function __construct()
    {
        $this->frente  = null;
        $this->tamanio = 0;
    }

    public function encolar($dato, $prioridad)
    {
        $nuevo = new NodoColaPrioridad($dato, $prioridad);

        if ($this->frente === null || $prioridad > $this->frente->prioridad) {
            $nuevo->siguiente = $this->frente;
            $this->frente     = $nuevo;
        } else {
            $this->insertarOrdenado($this->frente, $nuevo);
        }
        $this->tamanio++;
    }

    private function insertarOrdenado($nodo, $nuevo)
    {
        if ($nodo->siguiente === null || $nuevo->prioridad > $nodo->siguiente->prioridad) {
            $nuevo->siguiente = $nodo->siguiente;
            $nodo->siguiente  = $nuevo;
        } else {
            $this->insertarOrdenado($nodo->siguiente, $nuevo);
        }
    }

    public function desencolar()
    {
        if ($this->estaVacia()) {
            return null;
        }
        $dato         = $this->frente->dato;
        $this->frente = $this->frente->siguiente;
        $this->tamanio--;
        return $dato;
    }

    public function recorrer()
    {
        $elementos = [];
        $this->recorrerNodo($this->frente, $elementos);
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
        return $this->frente === null;
    }

    public function tamanio()
    {
        return $this->tamanio;
    }
}