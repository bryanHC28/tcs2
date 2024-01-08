<?php

namespace App\Http\Controllers\API\Resources;

use App\Http\Controllers\Controller;
use App\Models\TBSucursal;
use App\Models\TCSCategorias;
use App\Models\TCSControlCategorias;
use Illuminate\Http\Request;

class TCSCategoriasController extends Controller
{
    /**
     * Trae un catalogo de categorias basado en el id sucursal
     *
     * @param Int $id_sucursal
     *
     * @return TCSCategorias $collection
     */
    public function index(Int $id_sucursal)
    {
        $tb_sucursal = TBSucursal::query()
            ->where('id_sucursal', $id_sucursal)
            ->with(['tb_empresa'])
            ->firstOrFail();

        $tcs_control_categorias_empresa = TCSControlCategorias::query()
            ->where('idEmpresa', $tb_sucursal->tb_empresa->id_empresa)
            ->whereNull('idSucursal')
            ->get();

        $tcs_control_categorias_sucursal = TCSControlCategorias::query()
            ->where('idEmpresa', $tb_sucursal->tb_empresa->id_empresa)
            ->where('idSucursal', $tb_sucursal->id_sucursal)
            ->get();

        $tcs_control_categorias_ids = ($tcs_control_categorias_empresa->merge($tcs_control_categorias_sucursal))->pluck('idCategoria');

        $tcs_control_categorias = TCSCategorias::query()
            ->whereIn('id', $tcs_control_categorias_ids)
            ->get();

        $tcs_control_categorias = $tcs_control_categorias->map(function($item){
            return [
                'id' => $item->id,
                'categoria' => $item->categoria_descripcion
            ];
        });

        return response()->json($tcs_control_categorias);
    }
	   public function categariasAccor(Int $id_area){

        if($id_area==8){


            $data = TCSControlCategorias::select('tcs_control_categorias.idCategoria as id', 'tcs_categorias.categoria_descripcion as categoria')
                ->join('tcs_categorias', 'tcs_control_categorias.idCategoria', '=', 'tcs_categorias.id')
                ->where('tcs_control_categorias.idArea', 1)
                ->orderBy('tcs_categorias.categoria_descripcion')
                ->get();





        }else

        $data = TCSControlCategorias::select('tcs_control_categorias.idCategoria as id', 'tcs_categorias.categoria_descripcion as categoria')
        ->join('tcs_categorias', 'tcs_control_categorias.idCategoria', '=', 'tcs_categorias.id')
        ->where('tcs_control_categorias.idArea', 8)
        ->orderBy('tcs_categorias.categoria_descripcion')
        ->get();

        $data = $data->map(function($item){
            return [
                'id' => $item->id,
                'categoria' => $item->categoria
            ];
        });


        return response()->json($data);




    }


    public function categorias_lsm(Int $id_area){

        $tb_categorias = TCSControlCategorias::query()
            ->where('idArea', $id_area)    
            ->get();

            
        $nuevoArreglo = [];
            foreach ($tb_categorias as $item) {
                $nuevoArreglo[] =$item->categorias_lsm;
            }

            return $nuevoArreglo;

            return response()->json( $nuevoArreglo);
  




}


}