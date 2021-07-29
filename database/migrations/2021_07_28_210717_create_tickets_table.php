<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->string('id_empresa');
            $table->string('id_sucursal');
            $table->string('id_area')->nullable();
            $table->string('id_cfalla')->nullable();
            $table->string('id_sfalla')->nullable();
            $table->string('ticket_descripcion')->nullable();
            $table->string('transmitio')->nullable();
            $table->string('accion')->nullable();
            $table->string('observaciones')->nullable();
            $table->string('turno')->nullable();
            $table->string('estatus')->nullable();
            $table->float('costo', 8, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tickets');
    }
}
