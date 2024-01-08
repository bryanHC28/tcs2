<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Route;

class EstatusMail extends Mailable
{
    use Queueable, SerializesModels;


    public $subject = "Actualización de ticket";
    public $nombre, $folio, $estado;
   


    public function __construct($nombre,$folio,$estado)
    {
        $this->nombre = $nombre;
        $this->folio = $folio;
        $this->estado = $estado;
 

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('tickets.monalisaestado-mail');
    }
}
