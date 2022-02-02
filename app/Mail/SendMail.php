<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendMail extends Mailable
{
    use Queueable, SerializesModels;

    public $detail;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($detail)
    {
         $this->detail = $detail;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

//      return $this->subject('Maintan VTR');
        return $this->subject($this->detail[0]['AlertType'].' From AppealLab')->view('email.sendemail');
        //return $this->view('view.name');
    }
}
