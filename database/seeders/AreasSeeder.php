<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AreasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('areas')->insert([
            'area_clave' => 'AL',
            'area_descripcion' => 'ALMACEN'
        ]);
        DB::table('areas')->insert([
            'area_clave' => 'AP',
            'area_descripcion' => 'ÁREAS PÚBLICAS'
        ]);
        DB::table('areas')->insert([
            'area_clave' => 'AZ',
            'area_descripcion' => 'AZOTEA'
        ]);
        DB::table('areas')->insert([
            'area_clave' => 'BAR',
            'area_descripcion' => 'BAR'
        ]);
        DB::table('areas')->insert([
            'area_clave' => 'CM',
            'area_descripcion' => 'CUARTO DE MAQUINAS'
        ]);
        DB::table('areas')->insert([
            'area_clave' => 'CO',
            'area_descripcion' => 'COCINA'
        ]);
        DB::table('areas')->insert([
            'area_clave' => 'ES',
            'area_descripcion' => 'ESTACIONAMIENTO'
        ]);
        DB::table('areas')->insert([
            'area_clave' => 'HAB',
            'area_descripcion' => 'HABITACIONES'
        ]);
        DB::table('areas')->insert([
            'area_clave' => 'JAR',
            'area_descripcion' => 'JARDÍN'
        ]);
        DB::table('areas')->insert([
            'area_clave' => 'LB',
            'area_descripcion' => 'LOBBY'
        ]);
        DB::table('areas')->insert([
            'area_clave' => 'OF',
            'area_descripcion' => 'OFICINAS'
        ]);
        DB::table('areas')->insert([
            'area_clave' => 'P',
            'area_descripcion' => 'PASILLOS'
        ]);
        DB::table('areas')->insert([
            'area_clave' => 'RC',
            'area_descripcion' => 'RECEPCIÓN'
        ]);
        DB::table('areas')->insert([
            'area_clave' => 'RES',
            'area_descripcion' => 'RESTAURANTE'
        ]);
        DB::table('areas')->insert([
            'area_clave' => 'RO',
            'area_descripcion' => 'ROPERÍA'
        ]);
        DB::table('areas')->insert([
            'area_clave' => 'SJ',
            'area_descripcion' => 'SALA DE JUNTAS'
        ]);
        DB::table('areas')->insert([
            'area_clave' => 'SITE',
            'area_descripcion' => 'SITE'
        ]);
        DB::table('areas')->insert([
            'area_clave' => 'ST',
            'area_descripcion' => 'SÓTANO'
        ]);
        DB::table('areas')->insert([
            'area_clave' => 'VE',
            'area_descripcion' => 'VERTICALES'
        ]);
    }
}
