<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TBRespuesta extends Model
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
    protected $table = 'tb_respuesta';

    /**
     * Llave primaria a utilizar.
     *
     * @var string
     */
    protected $primaryKey = 'idrespuesta';


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
    public function encuesta()
    {
        return $this->hasOne(TBEncuesta::class, 'id_encuesta', 'idcuestionario');
    }

    public function bloque()
    {
        return $this->hasOne(TBEncuestaBloque::class, 'id_bloque', 'idbloque');
    }

    public function pregunta()
    {
        return $this->hasOne(TBEncuestaPregunta::class, 'id_pregunta', 'idpregunta');
    }

    /**
     * Scopes
     */
    public function scopeFiltroDiarioGaugeCardProgreso(Builder $query, String $nombre_encuesta, Carbon $fecha)
    {
        if ($nombre_encuesta == 'Diario') {
            return $query->whereDay('fecha', $fecha->day);
        }
    }
}
