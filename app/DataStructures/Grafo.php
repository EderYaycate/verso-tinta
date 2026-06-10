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

    // Agregar autor como vertice
    public function agregarVertice($autor)
    {
        if (!isset($this->vertices[$autor])) {
            $this->vertices[$autor] = $autor;
            $this->aristas[$autor] = [];
        }
    }

    // Conectar dos autores que comparten categoria
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

    // Obtener vecinos de un autor
    public function obtenerVecinos($autor)
    {
        if (!isset($this->aristas[$autor])) return [];
        return $this->aristas[$autor];
    }

    // Obtener todos los vertices
    public function obtenerVertices()
    {
        return $this->vertices;
    }

    // Obtener todas las aristas
    public function obtenerAristas()
    {
        return $this->aristas;
    }

    // Recorrer en anchura BFS desde un autor
    public function bfs($inicio)
    {
        $visitados = [];
        $cola = [];
        $resultado = [];

        $visitados[$inicio] = true;
        $cola[] = $inicio;

        $i = 0;
        while ($i < count($cola)) {
            $actual = $cola[$i];
            $resultado[] = $actual;

            $j = 0;
            $vecinos = $this->aristas[$actual] ?? [];
            while ($j < count($vecinos)) {
                $vecino = $vecinos[$j]['destino'];
                if (!isset($visitados[$vecino])) {
                    $visitados[$vecino] = true;
                    $cola[] = $vecino;
                }
                $j++;
            }
            $i++;
        }

        return $resultado;
    }
}