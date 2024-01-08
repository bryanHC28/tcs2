<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Route;

class getMail extends Mailable
{
    use Queueable, SerializesModels;


    public $subject = "Actualización de estatus de ticket";
    public $ticket;
    public $userAuth;
    public $link;
    public $descripcion;

    public function __construct($ticket,$descripcion)
    {
        $this->ticket = $ticket;
        $this->descripcion= $descripcion;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('tickets.get-email');
    }
}
