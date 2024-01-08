<?php

namespace App\Http\Controllers\API\Resources;

use App\Http\Controllers\Controller;
use App\Models\TBSucursal;
use App\Models\TCSTransmitio;
use App\Models\TCSControlTransmitio;
use Illuminate\Http\Request;

class TCSTransmitioController extends Controller
{
    /**
     * Trae un catalogo de transmitio basado en el id sucursal
     *
     * @param Int $id_sucursal
     *
     * @return TCSTransmitio $collection
     */
    public function index(Int $id_sucursal)
    {
        $tb_sucursal = TBSucursal::query()
            ->where('id_sucursal', $id_sucursal)
            ->with(['tb_empresa'])
            ->firstOrFail();

        $tcs_control_transmitio_empresa = TCSControlTransmitio::query()
            ->where('idEmpresa', $tb_sucursal->tb_empresa->id_empresa)
            ->whereNull('idSucursal')
            ->get();

        $tcs_control_transmitio_sucursal = TCSControlTransmitio::query()
            ->where('idEmpresa', $tb_sucursal->tb_empresa->id_empresa)
            ->where('idSucursal', $tb_sucursal->id_sucursal)
            ->get();

        $tcs_control_transmitio_ids = ($tcs_control_transmitio_empresa->merge($tcs_control_transmitio_sucursal))->pluck('idTransmitio');

        $tcs_control_transmitio = TCSTransmitio::query()
            ->whereIn('id', $tcs_control_transmitio_ids)
            ->get();

        $tcs_control_transmitio= $tcs_control_transmitio->map(function ($item) {
            return [
                'id' => $item->id,
                'transmitio' => $item->transmitio_descripcion
            ];
        });

        return response()->json($tcs_control_transmitio);
    }
}
