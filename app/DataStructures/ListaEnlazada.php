<?php

namespace App\DataStructures;

class ListaEnlazada
{
    private $head;
    private $count;

    public function __construct()
    {
        $this->head  = null;
        $this->count = 0;
    }

    private function CrearNodo($value)
    {
        return (object)[
            'value' => $value,
            'next'  => null,
        ];
    }

    private function BuscarUltimoNodo($nodoActual)
    {
        if ($nodoActual->next === null) {
            return $nodoActual;
        }
        return $this->BuscarUltimoNodo($nodoActual->next);
    }

    private function BuscarNodoPorId($nodoActual, $id)
    {
        if ($nodoActual === null) {
            return null;
        }
        if ($nodoActual->value['id'] === $id) {
            return $nodoActual->value;
        }
        return $this->BuscarNodoPorId($nodoActual->next, $id);
    }

    private function EliminarNodo($nodoActual, $id)
    {
        if ($nodoActual === null) {
            return null;
        }
        if ($nodoActual->value['id'] === $id) {
            return $nodoActual->next;
        }
        $nodoActual->next = $this->EliminarNodo($nodoActual->next, $id);
        return $nodoActual;
    }

    private function RecorrerNodo($nodoActual, &$elementos)
    {
        if ($nodoActual === null) {
            return;
        }
        $elementos[] = $nodoActual->value;
        $this->RecorrerNodo($nodoActual->next, $elementos);
    }

    public function InsertarAlInicio($value)
    {
        $newNode       = $this->CrearNodo($value);
        $newNode->next = $this->head;
        $this->head    = $newNode;
        $this->count++;
    }

    public function InsertarAlFinal($value)
    {
        $newNode = $this->CrearNodo($value);

        if ($this->head === null) {
            $this->head = $newNode;
        } else {
            $ultimoNodo       = $this->BuscarUltimoNodo($this->head);
            $ultimoNodo->next = $newNode;
        }

        $this->count++;
    }

    public function BuscarElemento($id)
    {
        return $this->BuscarNodoPorId($this->head, $id);
    }

    public function EliminarElemento($id)
    {
        $this->head = $this->EliminarNodo($this->head, $id);
        $this->count--;
    }

    public function ImprimirLista()
    {
        if ($this->head !== null) {
            $nodoActual = $this->head;
            while ($nodoActual !== null) {
                echo $nodoActual->value['id'] . ' -> ';
                $nodoActual = $nodoActual->next;
            }
            echo 'null' . PHP_EOL;
        } else {
            echo 'Lista vacía' . PHP_EOL;
        }
    }

    // Alias para compatibilidad con el proyecto Laravel
    public function insertar($dato)
    {
        $this->InsertarAlFinal($dato);
    }

    public function recorrer()
    {
        $elementos = [];
        $this->RecorrerNodo($this->head, $elementos);
        return $elementos;
    }

    public function buscar($id)
    {
        return $this->BuscarElemento($id);
    }

    public function eliminar($id)
    {
        $this->EliminarElemento($id);
    }

    public function ObtenerCapacidad()
    {
        return $this->count;
    }
}