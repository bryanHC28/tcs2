<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TBEmpresa extends Model
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
    protected $table = 'tb_empresa';

    /**
     * Llave primaria a utilizar.
     *
     * @var string
     */
    protected $primaryKey = 'id_empresa';


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
     * Relaciones
     *
     * @var array<string>
     */
    protected $with = [
        //
    ];

    /**
     * Sucursales Relationship
     *
     * @return object|null
     */
    public function sucursales()
    {
        return $this->hasMany(TBSucursal::class, 'id_empresa', 'id_empresa');
    }

    /**
     * Areas Relationship
     *
     * @return object|null
     */
    public function areas()
    {
        return $this->belongsToMany(Areas::class, ControlAreas::class, 'idEmpresa', 'id');
    }
 

    /**
     * Categorias Relationship
     *
     * @return object|null
     */
    public function tcs_categorias()
    {
        return $this->belongsToMany(TCSCategorias::class, TCSControlCategorias::class, 'idEmpresa', 'id');
    }

    /**
     * CFallas Relationship
     *
     * @return object|null
     */
    public function cfallas()
    {
        return $this->belongsToMany(CFallas::class, ControlCFallas::class, 'idEmpresa', 'id');
    }
}
