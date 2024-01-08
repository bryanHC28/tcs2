<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TCSCategorias extends Model
{
    use HasFactory;

    /**
     * Conexión a utilizar
     *
     * @var string
     */
    protected $connection = 'tickets';

    /**
     * Nombre de la tabla a utilizar.
     *
     * @var string
     */
    protected $table = 'tcs_categorias';

    /**
     * Llave primaria a utilizar.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * Los atributos que son asignables en masa.
     *
     * @var array<int, string>
     */
    protected $guarded = [];

    /**
     * Relaciones
     *
     * @var array<string>
     */
    protected $with = [
        //
    ];

    /**
     * Subcategorias Relationship
     *
     * @return object|null
     */
    public function tcs_subcategorias()
    {
        return $this->belongsToMany(TCSSubcategorias::class, TCSControlSubcategorias::class, 'idCategoria', 'id');
    }
}
