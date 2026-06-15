<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Categoria;
use App\Models\Autor;
use App\Models\Libro;

class DatosSeeder extends Seeder
{
    public function run(): void
    {
        // Categorias
        $novela      = Categoria::create(['nombre' => 'Novela',      'descripcion' => 'Obras de ficcion narrativa extensa']);
        $poesia      = Categoria::create(['nombre' => 'Poesia',      'descripcion' => 'Composiciones en verso']);
        $ciencia     = Categoria::create(['nombre' => 'Ciencia Ficcion', 'descripcion' => 'Ficcion basada en avances cientificos']);
        $historia    = Categoria::create(['nombre' => 'Historia',    'descripcion' => 'Obras historicas y biograficas']);
        $fantasia    = Categoria::create(['nombre' => 'Fantasia',    'descripcion' => 'Mundos imaginarios y magicos']);

        // Autores
        $garcia      = Autor::create(['nombre' => 'Gabriel Garcia Marquez', 'nacionalidad' => 'Colombiana']);
        $borges      = Autor::create(['nombre' => 'Jorge Luis Borges',      'nacionalidad' => 'Argentina']);
        $neruda      = Autor::create(['nombre' => 'Pablo Neruda',           'nacionalidad' => 'Chilena']);
        $vargas      = Autor::create(['nombre' => 'Mario Vargas Llosa',     'nacionalidad' => 'Peruana']);
        $allende     = Autor::create(['nombre' => 'Isabel Allende',         'nacionalidad' => 'Chilena']);
        $cortazar    = Autor::create(['nombre' => 'Julio Cortazar',         'nacionalidad' => 'Argentina']);
        $rulfo       = Autor::create(['nombre' => 'Juan Rulfo',             'nacionalidad' => 'Mexicana']);
        $fuentes     = Autor::create(['nombre' => 'Carlos Fuentes',         'nacionalidad' => 'Mexicana']);

        // Libros
        Libro::create(['titulo' => 'Cien Anos de Soledad',       'resumen' => 'La historia de la familia Buendia en Macondo a lo largo de siete generaciones.',          'portada' => null, 'autor_id' => $garcia->id,   'categoria_id' => $novela->id]);
        Libro::create(['titulo' => 'El Amor en los Tiempos del Colera', 'resumen' => 'Historia de amor que dura mas de cincuenta anos entre Florentino y Fermina.',       'portada' => null, 'autor_id' => $garcia->id,   'categoria_id' => $novela->id]);
        Libro::create(['titulo' => 'Ficciones',                  'resumen' => 'Coleccion de cuentos que exploran laberintos, espejos y tiempos paralelos.',               'portada' => null, 'autor_id' => $borges->id,   'categoria_id' => $fantasia->id]);
        Libro::create(['titulo' => 'El Aleph',                   'resumen' => 'Cuentos fantasticos que cuestionan la realidad y el infinito.',                            'portada' => null, 'autor_id' => $borges->id,   'categoria_id' => $fantasia->id]);
        Libro::create(['titulo' => 'Veinte Poemas de Amor',      'resumen' => 'Poemario que celebra el amor y la naturaleza con gran lirismo.',                           'portada' => null, 'autor_id' => $neruda->id,   'categoria_id' => $poesia->id]);
        Libro::create(['titulo' => 'Canto General',              'resumen' => 'Poema epico que recorre la historia y geografia de America Latina.',                       'portada' => null, 'autor_id' => $neruda->id,   'categoria_id' => $poesia->id]);
        Libro::create(['titulo' => 'La Ciudad y los Perros',     'resumen' => 'Novela sobre cadetes en un colegio militar de Lima y sus conflictos internos.',            'portada' => null, 'autor_id' => $vargas->id,   'categoria_id' => $novela->id]);
        Libro::create(['titulo' => 'La Casa Verde',              'resumen' => 'Relato de multiples historias entrelazadas en la selva y el desierto peruano.',            'portada' => null, 'autor_id' => $vargas->id,   'categoria_id' => $novela->id]);
        Libro::create(['titulo' => 'La Casa de los Espiritus',   'resumen' => 'Saga familiar que mezcla realismo magico con historia politica latinoamericana.',          'portada' => null, 'autor_id' => $allende->id,  'categoria_id' => $novela->id]);
        Libro::create(['titulo' => 'Eva Luna',                   'resumen' => 'Historia de una mujer que sobrevive gracias al poder de contar historias.',                'portada' => null, 'autor_id' => $allende->id,  'categoria_id' => $novela->id]);
        Libro::create(['titulo' => 'Rayuela',                    'resumen' => 'Novela experimental que puede leerse en distintos ordenes siguiendo instrucciones del autor.', 'portada' => null, 'autor_id' => $cortazar->id, 'categoria_id' => $novela->id]);
        Libro::create(['titulo' => 'Bestiario',                  'resumen' => 'Cuentos fantasticos con animales que irrumpen en la vida cotidiana.',                      'portada' => null, 'autor_id' => $cortazar->id, 'categoria_id' => $fantasia->id]);
        Libro::create(['titulo' => 'Pedro Paramo',               'resumen' => 'Un hombre busca a su padre en un pueblo fantasma lleno de almas en pena.',                 'portada' => null, 'autor_id' => $rulfo->id,    'categoria_id' => $novela->id]);
        Libro::create(['titulo' => 'El Llano en Llamas',         'resumen' => 'Cuentos sobre campesinos mexicanos marcados por la violencia y la pobreza.',               'portada' => null, 'autor_id' => $rulfo->id,    'categoria_id' => $historia->id]);
        Libro::create(['titulo' => 'La Muerte de Artemio Cruz',  'resumen' => 'Un hombre en su lecho de muerte recuerda su vida y las traiciones que cometio.',           'portada' => null, 'autor_id' => $fuentes->id,  'categoria_id' => $historia->id]);
        Libro::create(['titulo' => 'Terra Nostra',               'resumen' => 'Novela historica ambiciosa sobre el mundo hispanico desde la conquista hasta el futuro.',   'portada' => null, 'autor_id' => $fuentes->id,  'categoria_id' => $ciencia->id]);
    }
}