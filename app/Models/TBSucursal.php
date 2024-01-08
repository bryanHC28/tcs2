<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TBSucursal extends Model
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
    protected $table = 'tb_sucursal';

    /**
     * Llave primaria a utilizar.
     *
     * @var string
     */
    protected $primaryKey = 'id_sucursal';

    /**
     * Casts
     *
     * @var array
     */
    protected $casts = [
        //
    ];


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
     * TBApp Relationship
     *
     * @return object|null
     */
    public function tb_app()
    {
        return $this->hasOne(TBApp::class, 'id_app', 'id_app');
    }

    /**
     * TBEmpresa Relationship
     *
     * @return object|null
     */
    public function tb_empresa()
    {
        return $this->hasOne(TBEmpresa::class, 'id_empresa', 'id_empresa');
    }


    public function tb_usuario()
    {
        return $this->hasOne(Usuario::class, 'id_sucursal', 'id_sucursal');
    }

    /**
     * Areas Relationship
     *
     * @return object|null
     */
    public function areas()
    {
        return $this->belongsToMany(Areas::class, ControlAreas::class, 'idSucursal', 'idArea');
    }

    /**
     * Categorias Relationship
     *
     * @return object|null
     */
    public function tcs_categorias()
    {
        return $this->belongsToMany(TCSCategorias::class, TCSControlCategorias::class, 'idSucursal', 'idCategoria');
    }

    /**
     * CFallas Relationship
     *
     * @return object|null
     */
    public function cfallas()
    {
        return $this->belongsToMany(CFallas::class, ControlCFallas::class, 'idSucursal', 'idcfallas');
    }

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::addGlobalScope('by_empresa', function (Builder $builder) {
            if (auth()->check()) {
                $builder->where('id_empresa', auth()->user()->id_empresa);
            }
        });
    }
}
