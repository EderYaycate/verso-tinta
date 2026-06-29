<?php

namespace App\DataStructures;

class NodoListaCircular
{
    public $dato;
    public $siguiente;

    public function __construct($dato)
    {
        $this->dato      = $dato;
        $this->siguiente = null;
    }
}

class ListaCircular
{
    private $cabeza;
    private $tamanio;

    public function __construct()
    {
        $this->cabeza  = null;
        $this->tamanio = 0;
    }

    public function insertar($dato)
    {
        $nuevo = new NodoListaCircular($dato);

        if ($this->cabeza === null) {
            $this->cabeza          = $nuevo;
            $nuevo->siguiente      = $this->cabeza;
        } else {
            $this->insertarAlFinal($this->cabeza, $nuevo);
        }
        $this->tamanio++;
    }

    private function insertarAlFinal($nodo, $nuevo)
    {
        if ($nodo->siguiente === $this->cabeza) {
            $nodo->siguiente  = $nuevo;
            $nuevo->siguiente = $this->cabeza;
        } else {
            $this->insertarAlFinal($nodo->siguiente, $nuevo);
        }
    }

    public function recorrer()
    {
        if ($this->cabeza === null) {
            return [];
        }
        $elementos = [];
        $this->recorrerNodo($this->cabeza, $elementos, 0);
        return $elementos;
    }

    private function recorrerNodo($nodo, &$elementos, $contador)
    {
        if ($contador === $this->tamanio) {
            return;
        }
        $elementos[] = $nodo->dato;
        $this->recorrerNodo($nodo->siguiente, $elementos, $contador + 1);
    }

    public function estaVacia()
    {
        return $this->cabeza === null;
    }

    public function tamanio()
    {
        return $this->tamanio;
    }
}