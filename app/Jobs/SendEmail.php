<?php

namespace App\Jobs;

use App\Mail\EmailForQueue;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Mail\Mailable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;


class SendEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    public $subject ;
    public $ticket;

    public $descripcion;
    public $email;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($ticket,$subject,$descripcion,$email)
    {
        $this->ticket = $ticket;

        $this->subject = $subject;

        $this->descripcion= $descripcion;
        $this->email= $email;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $email = new EmailForQueue( $this->ticket,$this->subject,$this->descripcion);
        Mail::to($this->email)->send( $email);

    }
}
