<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RatingReview extends Mailable
{
    use Queueable, SerializesModels;

    public $mailSenderArray;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($mailSenderArray)
    {
        $this->mailSenderArray = $mailSenderArray;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

//      return $this->subject('Maintan VTR');
        return $this->subject('Rating & Review From AppealLab')->view('email.walmart_rating_review');
        //return $this->view('view.name');
    }
}
