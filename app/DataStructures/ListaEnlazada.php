<?php

namespace App\DataStructures;

class ListaEnlazada
{
    private array $elementos = [];

    public function insertar(array $dato): void
    {
        $this->elementos[] = $dato;
    }

    public function recorrer(): array
    {
        return $this->elementos;
    }

    public function eliminar(int $id): void
    {
        $this->elementos = array_values(
            array_filter($this->elementos, fn($e) => $e['id'] !== $id)
        );
    }

    public function buscar(int $id): ?array
    {
        foreach ($this->elementos as $elemento) {
            if ($elemento['id'] === $id) {
                return $elemento;
            }
        }
        return null;
    }
}
