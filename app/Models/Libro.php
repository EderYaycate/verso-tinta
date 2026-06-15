<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $titulo
 * @property string $resumen
 * @property string $portada
 * @property float $precio
 * @property int $autor_id
 * @property int $categoria_id
 */
class Libro extends Model
{
    protected $fillable = ['titulo', 'resumen', 'portada', 'precio', 'autor_id', 'categoria_id'];

    public function autor()
    {
        return $this->belongsTo(Autor::class);
    }

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

    public function carritoItems()
    {
        return $this->hasMany(Carrito::class);
    }
}