<?php

namespace App\DataStructures;

class NodoAVL
{
    public $dato;
    public $izquierdo;
    public $derecho;
    public $altura;

    public function __construct($dato)
    {
        $this->dato = $dato;
        $this->izquierdo = null;
        $this->derecho = null;
        $this->altura = 1;
    }
}

class ArbolAVL
{
    private $raiz;

    public function __construct()
    {
        $this->raiz = null;
    }

    private function altura($nodo)
    {
        if ($nodo === null) return 0;
        return $nodo->altura;
    }

    private function factor($nodo)
    {
        if ($nodo === null) return 0;
        return $this->altura($nodo->izquierdo) - $this->altura($nodo->derecho);
    }

    private function actualizarAltura($nodo)
    {
        $nodo->altura = 1 + max(
            $this->altura($nodo->izquierdo),
            $this->altura($nodo->derecho)
        );
    }

    // Rotacion derecha
    private function rotarDerecha($y)
    {
        $x = $y->izquierdo;
        $T2 = $x->derecho;

        $x->derecho = $y;
        $y->izquierdo = $T2;

        $this->actualizarAltura($y);
        $this->actualizarAltura($x);

        return $x;
    }

    // Rotacion izquierda
    private function rotarIzquierda($x)
    {
        $y = $x->derecho;
        $T2 = $y->izquierdo;

        $y->izquierdo = $x;
        $x->derecho = $T2;

        $this->actualizarAltura($x);
        $this->actualizarAltura($y);

        return $y;
    }

    // Insertar por autor
    public function insertar($dato)
    {
        $this->raiz = $this->insertarNodo($this->raiz, $dato);
    }

    private function insertarNodo($nodo, $dato)
    {
        if ($nodo === null) return new NodoAVL($dato);

        if ($dato['autor'] < $nodo->dato['autor']) {
            $nodo->izquierdo = $this->insertarNodo($nodo->izquierdo, $dato);
        } elseif ($dato['autor'] > $nodo->dato['autor']) {
            $nodo->derecho = $this->insertarNodo($nodo->derecho, $dato);
        } else {
            return $nodo;
        }

        $this->actualizarAltura($nodo);
        $factor = $this->factor($nodo);

        // Rotacion izquierda izquierda
        if ($factor > 1 && $dato['autor'] < $nodo->izquierdo->dato['autor']) {
            return $this->rotarDerecha($nodo);
        }

        // Rotacion derecha derecha
        if ($factor < -1 && $dato['autor'] > $nodo->derecho->dato['autor']) {
            return $this->rotarIzquierda($nodo);
        }

        // Rotacion izquierda derecha
        if ($factor > 1 && $dato['autor'] > $nodo->izquierdo->dato['autor']) {
            $nodo->izquierdo = $this->rotarIzquierda($nodo->izquierdo);
            return $this->rotarDerecha($nodo);
        }

        // Rotacion derecha izquierda
        if ($factor < -1 && $dato['autor'] < $nodo->derecho->dato['autor']) {
            $nodo->derecho = $this->rotarDerecha($nodo->derecho);
            return $this->rotarIzquierda($nodo);
        }

        return $nodo;
    }

    // Buscar por autor
    public function buscar($autor)
    {
        return $this->buscarNodo($this->raiz, $autor);
    }

    private function buscarNodo($nodo, $autor)
    {
        if ($nodo === null) return null;

        if ($autor === $nodo->dato['autor']) return $nodo->dato;

        if ($autor < $nodo->dato['autor']) {
            return $this->buscarNodo($nodo->izquierdo, $autor);
        }

        return $this->buscarNodo($nodo->derecho, $autor);
    }

    // Recorrido inorden (devuelve libros ordenados por autor)
    public function inorden()
    {
        $resultado = [];
        $this->inordenRecursivo($this->raiz, $resultado);
        return $resultado;
    }

    private function inordenRecursivo($nodo, &$resultado)
    {
        if ($nodo === null) return;
        $this->inordenRecursivo($nodo->izquierdo, $resultado);
        $resultado[] = $nodo->dato;
        $this->inordenRecursivo($nodo->derecho, $resultado);
    }

    // Eliminar por autor
    public function eliminar($autor)
    {
        $this->raiz = $this->eliminarNodo($this->raiz, $autor);
    }

    private function eliminarNodo($nodo, $autor)
    {
        if ($nodo === null) return null;

        if ($autor < $nodo->dato['autor']) {
            $nodo->izquierdo = $this->eliminarNodo($nodo->izquierdo, $autor);
        } elseif ($autor > $nodo->dato['autor']) {
            $nodo->derecho = $this->eliminarNodo($nodo->derecho, $autor);
        } else {
            if ($nodo->izquierdo === null) return $nodo->derecho;
            if ($nodo->derecho === null) return $nodo->izquierdo;

            $minimo = $this->minimoNodo($nodo->derecho);
            $nodo->dato = $minimo->dato;
            $nodo->derecho = $this->eliminarNodo($nodo->derecho, $minimo->dato['autor']);
        }

        $this->actualizarAltura($nodo);
        $factor = $this->factor($nodo);

        if ($factor > 1 && $this->factor($nodo->izquierdo) >= 0) {
            return $this->rotarDerecha($nodo);
        }

        if ($factor > 1 && $this->factor($nodo->izquierdo) < 0) {
            $nodo->izquierdo = $this->rotarIzquierda($nodo->izquierdo);
            return $this->rotarDerecha($nodo);
        }

        if ($factor < -1 && $this->factor($nodo->derecho) <= 0) {
            return $this->rotarIzquierda($nodo);
        }

        if ($factor < -1 && $this->factor($nodo->derecho) > 0) {
            $nodo->derecho = $this->rotarDerecha($nodo->derecho);
            return $this->rotarIzquierda($nodo);
        }

        return $nodo;
    }

    private function minimoNodo($nodo)
    {
        while ($nodo->izquierdo !== null) {
            $nodo = $nodo->izquierdo;
        }
        return $nodo;
    }
}