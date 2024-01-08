<?php

namespace App\Http\Controllers\API\Resources;
use App\Models\{Usuario,nivel,TBSucursal,TBEmpresa,ControlAreas};
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AreasController extends Controller
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
            ->with(['areas'])
            ->firstOrFail();

        $areas = $tb_sucursal->areas->map(function ($item) {
            return [
                'id' => $item->id,
                'area' => $item->area_descripcion,
            ];
        });

        return response()->json($areas);
    }
    public function areas_lsm()
    {


        $tb_areas = ControlAreas::query()
            ->where('idEmpresa', 44)
            ->with(['areas_lsm'])
            ->get();
        $nuevoArreglo = [];
            foreach ($tb_areas as $item) {
                $nuevoArreglo[] =$item->areas_lsm;
            }

            return response()->json( $nuevoArreglo);
  
    }
    public function responzable(Int $id_sucursal){


        if($id_sucursal==200 ||$id_sucursal==217)

            $Usu = Usuario::query()
            ->where('id_sucursal', 200)
            ->get();

        else

        $Usu = Usuario::query()
        ->where('id_sucursal', $id_sucursal)
        ->get();

        $Usu = $Usu->map(function($item){
            return [
                'nombre' => $item->nombre.' '.$item->apellido,
                'realizo' => $item->nombre.' '.$item->apellido
            ];
        });


        return response()->json($Usu);


    }

    public function niveles($id_area){
        $tb_niveles = nivel::query()
        ->where('idarea', $id_area)
        ->get();


        return response()->json($tb_niveles);
    }


    public function niveles_trbl($id_subarea){
        $tb_niveles = nivel::query()
        ->where('idsubarea', $id_subarea)
        ->get();


        return response()->json($tb_niveles);
    }
}
