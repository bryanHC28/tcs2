<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Route;

class TicketcreateMail extends Mailable
{
    use Queueable, SerializesModels;


    public $subject = "Nuevo ticket";
    public $ticket,$usuario,$area,$descripcion,$equipo;

    public function __construct($ticket, $usuario,$area,$descripcion,$equipo)
    {
        $this->ticket = $ticket;
        $this->usuario = $usuario;
        $this->area = $area;
        $this->descripcion = $descripcion;
        $this->equipo = $equipo;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('tickets.create-mail');
    }
}
