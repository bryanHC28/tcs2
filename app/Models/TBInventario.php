<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TBInventario extends Model
{
    use HasFactory;
    protected $connection = 'tickets';

    /**
     * Nombre de la tabla a utilizar.
     *
     * @var string
     */
    protected $table = 'inventarios';

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
}
