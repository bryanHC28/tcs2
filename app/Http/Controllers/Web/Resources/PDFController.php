<?php

namespace App\Http\Controllers\Web\Resources;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PDF;
use Illuminate\Support\Facades\{DB};
class PDFController extends Controller
{

    
public function generarPDF($id)
{
   $ticket = DB::connection('tickets')->table('tickets')->where('id',$id)->get();
   
   $data = array(
    'id' => $ticket[0]->id,
    'sucursal' => $ticket[0]->sucursal,
    'area' => $ticket[0]->area,
    'subarea' => $ticket[0]->subarea,
    'fecha_estimada' => $ticket[0]->fecha_estimada,
    'estatus' => $ticket[0]->estatus,
    'autor' => $ticket[0]->usuario,
    'responsable' => $ticket[0]->realizo,
    'accion' => $ticket[0]->accion,
    'observaciones' => $ticket[0]->observaciones,
    'prioridad' => $ticket[0]->prioridad,
    'categoria' => $ticket[0]->categoria,
    'descripcion' => $ticket[0]->ticket_descripcion,
    'habitacion' => $ticket[0]->habitacion
     
);
 
      $pdf = PDF::loadView('tickets.ticket', $data);
    return response($pdf->output(), 200, [
        'Content-Type' => 'application/pdf',
        'Content-Disposition' => 'inline; filename="documento.pdf"',
    ]);
}
}
