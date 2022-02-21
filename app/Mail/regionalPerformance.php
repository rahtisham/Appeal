<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class regionalPerformance extends Mailable
{
    use Queueable, SerializesModels;
    public $regionalCity;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($regionalCity)
    {
        $this->regionalCity = $regionalCity;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // return $this->view('view.name');
        return $this->subject('Regional Performance From AppealLab')->view('email.walmart_regional_performance');
    }
}
