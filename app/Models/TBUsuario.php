<?php

namespace App\Models;

use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class TBUsuario extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

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
    protected $table = 'tb_usuario';

    /**
     * Llave primaria a utilizar.
     *
     * @var string
     */
    protected $primaryKey = 'id_usuario';


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
     * Atributos
     *
     * @var array<string>
     */
    protected $appends = [
        'nombre_completo'
    ];

    public function getNombreCompletoAttribute()
    {
        return "{$this->nombre} {$this->apellido}";
    }

    /**
     * Relaciones
     *
     * @var array<string>
     */
    protected $with = [
        //
    ];

    /**
     * Empresa Relationship
     *
     * @return object|null
     */
    public function empresa()
    {
        return $this->hasOne(TBEmpresa::class, 'id_empresa', 'id_empresa');
    }

    /**
     * Sucusal Relationship
     *
     * @return object|null
     */
    public function sucursal()
    {
        return $this->hasOne(TBSucursal::class, 'id_sucursal', 'id_sucursal');
    }
	
	    public function app(){
        return $this->belongsTo('App\Models\TBApp','id_app','id_app');
        }

    /**
     * ----------------------------------------
     * AdminLTE
     * ----------------------------------------
     */

    /**
     * Get profile photo
     *
     * @return URL
     */
    public function adminlte_image()
    {
        return asset('img/undraw_male_avatar_323b.png');
    }
}
