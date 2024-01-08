<?php

namespace App\Http\Controllers\API\Resources;

use App\Models\TBSucursal;
use Illuminate\Http\Request;
use App\Models\TCSSubcategorias;
use App\Http\Controllers\Controller;
use App\Models\TCSControlSubcategorias;

class TCSSubcategoriasController extends Controller
{
    /**
     * Trae un catalogo de subcategorias basado en el id sucursal
     *
     * @param Int $id_sucursal
     * @param Int $id_categoria
     *
     * @return TCSSubcategorias $collection
     */
    public function index(Int $id_sucursal, Int $id_categoria)
    {
        $tb_sucursal = TBSucursal::query()
            ->where('id_sucursal', $id_sucursal)
            ->with(['tb_empresa'])
            ->firstOrFail();

        $tcs_subcategorias_empresa = TCSControlSubcategorias::query()
            ->where('idEmpresa', $tb_sucursal->tb_empresa->id_empresa)
            ->whereNull('idSucursal')
            ->where('idCategoria', $id_categoria)
            ->get();

        $tcs_subcategorias_sucursal = TCSControlSubcategorias::query()
            ->where('idEmpresa', $tb_sucursal->tb_empresa->id_empresa)
            ->where('idSucursal', $tb_sucursal->id_sucursal)
            ->where('idCategoria', $id_categoria)
            ->get();

        $tcs_subcategorias_ids = ($tcs_subcategorias_empresa->merge($tcs_subcategorias_sucursal))->pluck('idSubcategoria');

        $tcs_subcategorias = TCSSubcategorias::query()
            ->whereIn('id', $tcs_subcategorias_ids)
            ->get();

        $tcs_subcategorias = $tcs_subcategorias->map(function($item){
            return [
                'id' => $item->id,
                'subcategoria' => $item->descripcion_subcategoria
            ];
        });

        return response()->json($tcs_subcategorias);
    }
}
