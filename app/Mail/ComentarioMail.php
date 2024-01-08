<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Route;

class ComentarioMail extends Mailable
{
    use Queueable, SerializesModels;


    public $subject = "Actualización de ticket";
    public $nombre, $folio, $comentario;
   


    public function __construct($nombre,$folio,$comentario)
    {
        $this->nombre = $nombre;
        $this->folio = $folio;
        $this->comentario = $comentario;
 

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('tickets.comentario-mail');
    }
}
