<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
/**
 * @property string $titulo
 * @property string $resumen
 * @property string|null $portada
 * @property int $autor_id
 * @property int $categoria_id
 */
class Libro extends Model
{
    protected $table = 'libros';
    protected $fillable = ['titulo', 'resumen', 'portada', 'autor_id', 'categoria_id'];

    public function autor()
    {
        return $this->belongsTo(Autor::class);
    }

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }
}