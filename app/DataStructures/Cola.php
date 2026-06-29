<?php

namespace App\DataStructures;

class Cola
{
    private $head;
    private $tail;
    private $count;

    public function __construct()
    {
        $this->head  = null;
        $this->tail  = null;
        $this->count = 0;
    }

    private function CrearNodo($value)
    {
        return (object)[
            'value' => $value,
            'next'  => null,
        ];
    }

    private function RecorrerNodo($nodoActual, &$elementos)
    {
        if ($nodoActual === null) {
            return;
        }
        $elementos[] = $nodoActual->value;
        $this->RecorrerNodo($nodoActual->next, $elementos);
    }

    public function Encolar($value)
    {
        $newNode = $this->CrearNodo($value);

        if ($this->EstaVacia()) {
            $this->head = $newNode;
            $this->tail = $newNode;
        } else {
            $this->tail->next = $newNode;
            $this->tail       = $newNode;
        }

        $this->count++;
    }

    public function Desencolar()
    {
        if ($this->EstaVacia()) {
            return null;
        }

        $value      = $this->head->value;
        $this->head = $this->head->next;

        if ($this->head === null) {
            $this->tail = null;
        }

        $this->count--;
        return $value;
    }

    public function ObtenerFrente()
    {
        if ($this->EstaVacia()) {
            return null;
        }
        return $this->head->value;
    }

    public function ImprimirCola()
    {
        if ($this->head !== null) {
            $nodoActual = $this->head;
            while ($nodoActual !== null) {
                echo $nodoActual->value . ' -> ';
                $nodoActual = $nodoActual->next;
            }
            echo 'null' . PHP_EOL;
        } else {
            echo 'Cola vacía' . PHP_EOL;
        }
    }

    public function EstaVacia()
    {
        return $this->head === null;
    }

    public function ObtenerCapacidad()
    {
        return $this->count;
    }

    public function recorrer()
    {
        $elementos = [];
        $this->RecorrerNodo($this->head, $elementos);
        return $elementos;
    }
}