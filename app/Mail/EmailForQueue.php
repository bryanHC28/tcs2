<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmailForQueue extends Mailable
{
    use Queueable, SerializesModels;
    public $subject ;
    public $ticket;

    public $descripcion;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($ticket,$subject,$descripcion)
    {
        $this->ticket = $ticket;

        $this->subject = $subject;

        $this->descripcion= $descripcion;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('soporte@empresavirtual.mx','Empresa Virtual')
                    ->subject($this->subject)
                    ->view('tickets.get-email')
                    ->with([
                        'ticket'=> $this->ticket
                    ]);
    }
}
