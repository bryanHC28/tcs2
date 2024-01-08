<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Route;

class SendMail extends Mailable
{
    use Queueable, SerializesModels;


    public $subject = "Actualización de estatus de ticket";
    public $ticket;
    public $userAuth;
    public $link;

    public function __construct($ticket, $userAuth,$link)
    {
        $this->ticket = $ticket;
        $this->userAuth = $userAuth;
        $this->link= $link;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('tickets.send-email');
    }
}
