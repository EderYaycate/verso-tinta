<?php

namespace App\DataStructures;

class Grafo
{
    private $vertices;
    private $aristas;

    public function __construct()
    {
        $this->vertices = [];
        $this->aristas  = [];
    }

    private function VerticeExiste($autor)
    {
        return isset($this->vertices[$autor]);
    }

    private function ProcesarVecinos($vecinos, &$cola, &$visitados, $indice)
    {
        if ($indice >= count($vecinos)) {
            return;
        }

        $vecino = $vecinos[$indice]['destino'];
        if (!isset($visitados[$vecino])) {
            $visitados[$vecino] = true;
            $cola[]             = $vecino;
        }

        $this->ProcesarVecinos($vecinos, $cola, $visitados, $indice + 1);
    }

    private function RecorridoBfsRecursivo($cola, &$visitados, &$resultado, $indice)
    {
        if ($indice >= count($cola)) {
            return;
        }

        $actual      = $cola[$indice];
        $resultado[] = $actual;

        $vecinos = $this->aristas[$actual] ?? [];
        $this->ProcesarVecinos($vecinos, $cola, $visitados, 0);

        $this->RecorridoBfsRecursivo($cola, $visitados, $resultado, $indice + 1);
    }

    public function AgregarVertice($autor)
    {
        if (!$this->VerticeExiste($autor)) {
            $this->vertices[$autor] = $autor;
            $this->aristas[$autor]  = [];
        }
    }

    public function AgregarArista($autor1, $autor2, $categoria)
    {
        $this->AgregarVertice($autor1);
        $this->AgregarVertice($autor2);

        $this->aristas[$autor1][] = [
            'destino'   => $autor2,
            'categoria' => $categoria,
        ];

        $this->aristas[$autor2][] = [
            'destino'   => $autor1,
            'categoria' => $categoria,
        ];
    }

    public function ObtenerVecinos($autor)
    {
        if (!$this->VerticeExiste($autor)) {
            return [];
        }
        return $this->aristas[$autor];
    }

    public function ObtenerVertices()
    {
        return $this->vertices;
    }

    public function ObtenerAristas()
    {
        return $this->aristas;
    }

    public function RecorridoBfs($inicio)
    {
        $visitados          = [];
        $cola               = [];
        $resultado          = [];
        $visitados[$inicio] = true;
        $cola[]             = $inicio;

        $this->RecorridoBfsRecursivo($cola, $visitados, $resultado, 0);

        return $resultado;
    }
}