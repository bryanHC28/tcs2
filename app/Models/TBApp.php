<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TBApp extends Model
{
    use HasFactory;

    /**
     * Conexión a utilizar
     *
     * @var string
     */
    protected $connection = 'EV_SUMAPP';

    /**
     * Nombre de la tabla a utilizar.
     *
     * @var string
     */
    protected $table = 'tb_app';

    /**
     * Llave primaria a utilizar.
     *
     * @var string
     */
    protected $primaryKey = 'id_app';


    /**
     * Deshabilitar timestamps de laravel
     *
     * @var string
     */
    public $timestamps = false;

    /**
     * Los atributos que son asignables en masa.
     *
     * @var array<int, string>
     */
    protected $guarded = [];

    /**
     * Relationships
     */
    protected $with = [
        //
    ];

    public function sucursales()
    {
        return $this->hasMany(TBSucursal::class, 'id_app', 'id_app');
    }
}
