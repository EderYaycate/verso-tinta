<?php

namespace App\DataStructures;

class ArbolBinario
{
    private $raiz;

    public function __construct()
    {
        $this->raiz = null;
    }

    private function CrearNodo($value)
    {
        return (object)[
            'value'         => $value,
            'hijoIzquierdo' => null,
            'hijoDerecho'   => null,
        ];
    }

    private function InsertarNodo($nodoActual, $value)
    {
        if ($nodoActual === null) {
            return $this->CrearNodo($value);
        }

        if ($value['titulo'] < $nodoActual->value['titulo']) {
            $nodoActual->hijoIzquierdo = $this->InsertarNodo($nodoActual->hijoIzquierdo, $value);
        } elseif ($value['titulo'] > $nodoActual->value['titulo']) {
            $nodoActual->hijoDerecho = $this->InsertarNodo($nodoActual->hijoDerecho, $value);
        }

        return $nodoActual;
    }

    private function BuscarNodo($nodoActual, $titulo)
    {
        if ($nodoActual === null) {
            return null;
        }

        if ($titulo === $nodoActual->value['titulo']) {
            return $nodoActual->value;
        }

        if ($titulo < $nodoActual->value['titulo']) {
            return $this->BuscarNodo($nodoActual->hijoIzquierdo, $titulo);
        }

        return $this->BuscarNodo($nodoActual->hijoDerecho, $titulo);
    }

    private function BuscarMinimoNodo($nodoActual)
    {
        if ($nodoActual->hijoIzquierdo === null) {
            return $nodoActual;
        }
        return $this->BuscarMinimoNodo($nodoActual->hijoIzquierdo);
    }

    private function EliminarNodo($nodoActual, $titulo)
    {
        if ($nodoActual === null) {
            return null;
        }

        if ($titulo < $nodoActual->value['titulo']) {
            $nodoActual->hijoIzquierdo = $this->EliminarNodo($nodoActual->hijoIzquierdo, $titulo);
        } elseif ($titulo > $nodoActual->value['titulo']) {
            $nodoActual->hijoDerecho = $this->EliminarNodo($nodoActual->hijoDerecho, $titulo);
        } else {
            if ($nodoActual->hijoIzquierdo === null) {
                return $nodoActual->hijoDerecho;
            }
            if ($nodoActual->hijoDerecho === null) {
                return $nodoActual->hijoIzquierdo;
            }

            $minimo                  = $this->BuscarMinimoNodo($nodoActual->hijoDerecho);
            $nodoActual->value       = $minimo->value;
            $nodoActual->hijoDerecho = $this->EliminarNodo($nodoActual->hijoDerecho, $minimo->value['titulo']);
        }

        return $nodoActual;
    }

    private function RecursiveInOrden($nodoActual, &$resultado)
    {
        // IN-ORDEN: I - R - D
        if ($nodoActual !== null) {
            $this->RecursiveInOrden($nodoActual->hijoIzquierdo, $resultado);
            $resultado[] = $nodoActual->value;
            $this->RecursiveInOrden($nodoActual->hijoDerecho, $resultado);
        }
    }

    private function RecursivePreOrden($nodoActual, &$resultado)
    {
        // PRE-ORDEN: R - I - D
        if ($nodoActual !== null) {
            $resultado[] = $nodoActual->value;
            $this->RecursivePreOrden($nodoActual->hijoIzquierdo, $resultado);
            $this->RecursivePreOrden($nodoActual->hijoDerecho, $resultado);
        }
    }

    private function RecursivePostOrden($nodoActual, &$resultado)
    {
        // POST-ORDEN: I - D - R
        if ($nodoActual !== null) {
            $this->RecursivePostOrden($nodoActual->hijoIzquierdo, $resultado);
            $this->RecursivePostOrden($nodoActual->hijoDerecho, $resultado);
            $resultado[] = $nodoActual->value;
        }
    }

    private function BuscarRangoNodo($nodoActual, $min, $max, &$resultado)
    {
        if ($nodoActual === null) {
            return;
        }

        if ($nodoActual->value['precio'] >= $min && $nodoActual->value['precio'] <= $max) {
            $resultado[] = $nodoActual->value;
        }

        $this->BuscarRangoNodo($nodoActual->hijoIzquierdo, $min, $max, $resultado);
        $this->BuscarRangoNodo($nodoActual->hijoDerecho, $min, $max, $resultado);
    }

    public function AñadirNodo($value)
    {
        $this->raiz = $this->InsertarNodo($this->raiz, $value);
    }

    public function BuscarElemento($titulo)
    {
        return $this->BuscarNodo($this->raiz, $titulo);
    }

    public function EliminarElemento($titulo)
    {
        $this->raiz = $this->EliminarNodo($this->raiz, $titulo);
    }

    public function InOrden()
    {
        $resultado = [];
        $this->RecursiveInOrden($this->raiz, $resultado);
        return $resultado;
    }

    public function PreOrden()
    {
        $resultado = [];
        $this->RecursivePreOrden($this->raiz, $resultado);
        return $resultado;
    }

    public function PostOrden()
    {
        $resultado = [];
        $this->RecursivePostOrden($this->raiz, $resultado);
        return $resultado;
    }

    public function BuscarPorRango($min, $max)
    {
        $resultado = [];
        $this->BuscarRangoNodo($this->raiz, $min, $max, $resultado);
        return $resultado;
    }
}