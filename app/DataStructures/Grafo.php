<?php

namespace App\DataStructures;

class Grafo
{
    private $vertices;
    private $aristas;

    public function __construct()
    {
        $this->vertices = [];
        $this->aristas = [];
    }

    public function agregarVertice($autor)
    {
        if (!isset($this->vertices[$autor])) {
            $this->vertices[$autor] = $autor;
            $this->aristas[$autor] = [];
        }
    }

    public function agregarArista($autor1, $autor2, $categoria)
    {
        $this->agregarVertice($autor1);
        $this->agregarVertice($autor2);

        $this->aristas[$autor1][] = [
            'destino'   => $autor2,
            'categoria' => $categoria,
        ];

        $this->aristas[$autor2][] = [
            'destino'   => $autor1,
            'categoria' => $categoria,
        ];
    }

    public function obtenerVecinos($autor)
    {
        if (!isset($this->aristas[$autor])) {
            return [];
        }
        return $this->aristas[$autor];
    }

    public function obtenerVertices()
    {
        return $this->vertices;
    }

    public function obtenerAristas()
    {
        return $this->aristas;
    }

    public function bfs($inicio)
    {
        $visitados = [];
        $cola = [];
        $resultado = [];

        $visitados[$inicio] = true;
        $cola[] = $inicio;

        $this->bfsRecursivo($cola, $visitados, $resultado, 0);

        return $resultado;
    }

    private function bfsRecursivo($cola, &$visitados, &$resultado, $indice)
    {
        if ($indice >= count($cola)) {
            return;
        }

        $actual = $cola[$indice];
        $resultado[] = $actual;

        $vecinos = $this->aristas[$actual] ?? [];
        $this->procesarVecinos($vecinos, $cola, $visitados, 0);

        $this->bfsRecursivo($cola, $visitados, $resultado, $indice + 1);
    }

    private function procesarVecinos($vecinos, &$cola, &$visitados, $indice)
    {
        if ($indice >= count($vecinos)) {
            return;
        }

        $vecino = $vecinos[$indice]['destino'];
        if (!isset($visitados[$vecino])) {
            $visitados[$vecino] = true;
            $cola[] = $vecino;
        }

        $this->procesarVecinos($vecinos, $cola, $visitados, $indice + 1);
    }
}