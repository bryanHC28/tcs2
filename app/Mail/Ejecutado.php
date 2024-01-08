<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Route;

class Ejecutado extends Mailable
{
    use Queueable, SerializesModels;


    public $subject = "Actualización de estatus de ticket";
    public $transmitio;
    public $get_id;


    public function __construct($transmitio, $get_id)
    {
        $this->transmitio = $transmitio;
        $this->$get_id = $get_id;

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('tickets.ejecutado');
    }
}
