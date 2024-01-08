<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Route;

class cron extends Mailable
{
    use Queueable, SerializesModels;


    public $subject = "Actualización de estatus de ticket";
    public $id;

    public function __construct($id)
    {

        $this->id = $id;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('tickets.cron-mail');
    }
}
