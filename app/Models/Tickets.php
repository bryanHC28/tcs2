<?php

namespace App\Models;

use Illuminate\Support\Str;


use Illuminate\Support\Facades\{DB,Mail};
use App\Mail\cron;
use App\Scopes\TicketsByRole;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tickets extends Model
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
    protected $table = 'tickets';

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
     * Attributes
     */
    protected $appends = [
        //
    ];

    /**
     * Carpeta Evidencia Inicial
     *
     * @return String|null $carpeta_evidencia_inicial
     */
    public function getCarpetaEvidenciaAttribute()
    {
        $tb_sucursal = TBSucursal::query()
            ->where('sucursal', $this->sucursal)
            ->first();

        if (!$tb_sucursal) {
            return null;
        }

        if (!$tb_sucursal->tb_app) {
            return null;
        }

        return $tb_sucursal->tb_app->carpeta;
    }

    /**
     * URL Evidencia Inicial
     *
     * @return String|null $url_evidencia
     */
    public function getUrlEvidenciaInicialAttribute()
    {
        if ($this->carpeta_evidencia == null) {
            return null;
        }

        $nombre_imagen = $this->evidenciaInicial;

        if ($this->ticket_sumapp != null) {
            $base = "https://fotos.sumapp.cloud/Sumapp";
        } else {
            $base = "https://fotostickets.sumapp.cloud";
        }

        return "{$base}/{$this->carpeta_evidencia}/{$nombre_imagen}";
    }

    /**
     * URL Evidencia Inicial
     *
     * @return String|null $url_evidencia
     */
    public function getUrlEvidenciaFinalAttribute()
    {
        if ($this->carpeta_evidencia == null) {
            return null;
        }

        $nombre_imagen = $this->evidenciaFinal;
        $base = "https://fotostickets.sumapp.cloud";

        return "{$base}/{$this->carpeta_evidencia}/{$nombre_imagen}";
    }

    /**
     * The "booted" method of the model.
     *
     * @return void
     */


     public function cron()
     {


         $cron = DB::connection('tickets')->table('tickets')->where('empresa','DemoProyectos9')->get();



         foreach ($cron as $sku) {


             $fechaActual = date('Y-m-d');
             $fecha_prox = date('Y-m-d', strtotime($sku->fecha_estimada));
             $fecha1 = date_create($fechaActual);
             $fecha2 = date_create($fecha_prox);
             $dias = date_diff($fecha1, $fecha2)->format('%R%a');



             if($sku->estatus=='Abierto' && $dias<0){

                    $pdte = "UPDATE tickets.tickets SET estado = 'Vencido' where id=$sku->id ";
                    DB::update($pdte);

             }elseif($sku->estatus=='Cancelado'){

                $pdte = "UPDATE tickets.tickets SET estado = 'inactivo' where id=$sku->id ";
                DB::update($pdte);

             }elseif($sku->estatus=='Ejecutado'){

                $pdte = "UPDATE tickets.tickets SET estado = 'En revisión' where id=$sku->id ";
                DB::update($pdte);

             }
             elseif($sku->estatus=='Cerrado'){

                $pdte = "UPDATE tickets.tickets SET estado = 'Aprobado' where id=$sku->id ";
                DB::update($pdte);

             }elseif($sku->estatus=='Abierto' && $dias >= 0){

                $pdte = "UPDATE tickets.tickets SET estado = 'En proceso' where id=$sku->id ";
                DB::update($pdte);

             }




            //  if ($dias< 0) {

            //      $pdte = "UPDATE tickets.tickets SET estado = 'Vencido' where id=$sku->id ";
            //      DB::update($pdte);
            //  }
         }
     Mail::to('bryaaan99@gmail.com')->queue(new cron(10));
         return "listo";

     }


     public function distrito()
     {
        return $this->belongsTo('App\Models\TBSucursal','sucursal','sucursal');
     }


    protected static function booted()
    {
        static::addGlobalScope('by_role', function (Builder $builder) {
            if (auth()->check()) {
                $auth = auth()->user();
                if (Str::contains($auth->rol_tickets, 'Corporativo')) {
                    $builder->where('empresa', $auth->empresa->c_nombre_empresa);
                } else {
                    $builder->where('sucursal', $auth->sucursal->sucursal);
                }
            }
        });
    }


}
