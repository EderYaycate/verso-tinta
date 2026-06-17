<?php

namespace App\DataStructures;

class Nodo
{
    public $dato;
    public $siguiente;

    public function __construct($dato)
    {
        $this->dato = $dato;
        $this->siguiente = null;
    }
}

class ListaEnlazada
{
    private $cabeza;
    private $tamanio;

    public function __construct()
    {
        $this->cabeza = null;
        $this->tamanio = 0;
    }

    public function insertar($dato)
    {
        $nuevo = new Nodo($dato);
        if ($this->cabeza === null) {
            $this->cabeza = $nuevo;
        } else {
            $this->insertarAlFinal($this->cabeza, $nuevo);
        }
        $this->tamanio++;
    }

    private function insertarAlFinal($nodo, $nuevo)
    {
        if ($nodo->siguiente === null) {
            $nodo->siguiente = $nuevo;
            return;
        }
        $this->insertarAlFinal($nodo->siguiente, $nuevo);
    }

    public function recorrer()
    {
        $elementos = [];
        $this->recorrerNodo($this->cabeza, $elementos);
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

    public function buscar($id)
    {
        return $this->buscarNodo($this->cabeza, $id);
    }

    private function buscarNodo($nodo, $id)
    {
        if ($nodo === null) {
            return null;
        }
        if ($nodo->dato['id'] === $id) {
            return $nodo->dato;
        }
        return $this->buscarNodo($nodo->siguiente, $id);
    }

    public function eliminar($id)
    {
        $this->cabeza = $this->eliminarNodo($this->cabeza, $id);
        $this->tamanio--;
    }

    private function eliminarNodo($nodo, $id)
    {
        if ($nodo === null) {
            return null;
        }
        if ($nodo->dato['id'] === $id) {
            return $nodo->siguiente;
        }
        $nodo->siguiente = $this->eliminarNodo($nodo->siguiente, $id);
        return $nodo;
    }

    public function tamanio()
    {
        return $this->tamanio;
    }
}