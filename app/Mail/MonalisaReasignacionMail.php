<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Route;

class MonalisaReasignacionMail extends Mailable
{
    use Queueable, SerializesModels;


    public $subject = "Actualización de ticket";
    public $transmitio, $folio ,$id;
   


    public function __construct($transmitio,$folio)
    {
        $this->transmitio = $transmitio;
        $this->folio = $folio;
 

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('tickets.monalisareasignacion-mail');
    }
}
