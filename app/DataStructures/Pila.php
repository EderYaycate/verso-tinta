<?php

namespace App\DataStructures;

class Pila
{
    private $top;
    private $count;

    public function __construct()
    {
        $this->top   = null;
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

    public function Apilar($value)
    {
        $newNode       = $this->CrearNodo($value);
        $newNode->next = $this->top;
        $this->top     = $newNode;
        $this->count++;
    }

    public function Desapilar()
    {
        if ($this->EstaVacia()) {
            return null;
        }
        $value     = $this->top->value;
        $this->top = $this->top->next;
        $this->count--;
        return $value;
    }

    public function ObtenerTope()
    {
        if ($this->EstaVacia()) {
            return null;
        }
        return $this->top->value;
    }

    public function ImprimirPila()
    {
        if ($this->top !== null) {
            $nodoActual = $this->top;
            while ($nodoActual !== null) {
                echo $nodoActual->value . ' -> ';
                $nodoActual = $nodoActual->next;
            }
            echo 'null' . PHP_EOL;
        } else {
            echo 'Pila vacía' . PHP_EOL;
        }
    }

    public function EstaVacia()
    {
        return $this->top === null;
    }

    public function ObtenerCapacidad()
    {
        return $this->count;
    }

    public function recorrer()
    {
        $elementos = [];
        $this->RecorrerNodo($this->top, $elementos);
        return $elementos;
    }
}