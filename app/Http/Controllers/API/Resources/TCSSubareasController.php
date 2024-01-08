<?php

namespace App\Http\Controllers\API\Resources;

use App\Models\TBSucursal;
use Illuminate\Http\Request;
use App\Models\TCSSubareas;
use App\Http\Controllers\Controller;
use App\Models\TCSControlSubareas;

class TCSSubareasController extends Controller
{
    /**
     * Trae un catalogo de subcategorias basado en el id sucursal
     *
     * @param Int $id_sucursal
     * @param Int $id_categoria
     *
     * @return TCSSubareas $collection
     */
    public function index(Int $id_sucursal, Int $id_area)
    {
        $tb_sucursal = TBSucursal::query()
            ->where('id_sucursal', $id_sucursal)
            ->with(['tb_empresa'])
            ->firstOrFail();

        $tcs_subareas_empresa = TCSControlSubareas::query()
            ->where('idEmpresa', $tb_sucursal->tb_empresa->id_empresa)
            ->whereNull('idSucursal')
            ->where('idArea', $id_area)
            ->get();

        $tcs_subareas_sucursal = TCSControlSubareas::query()
            ->where('idEmpresa', $tb_sucursal->tb_empresa->id_empresa)
            ->where('idSucursal', $tb_sucursal->id_sucursal)
            ->where('idArea', $id_area)
            ->get();

        $tcs_subareas_ids = ($tcs_subareas_empresa->merge($tcs_subareas_sucursal))->pluck('idSubarea');

        $tcs_subareas = TCSSubareas::query()
            ->whereIn('id', $tcs_subareas_ids)
            ->get();

        $tcs_subareas = $tcs_subareas->map(function ($item) {
            return [
                'id' => $item->id,
                'subarea' => $item->subarea_descripcion
            ];
        });

        return response()->json($tcs_subareas);
    }
}
