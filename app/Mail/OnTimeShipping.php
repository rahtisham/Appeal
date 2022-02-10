<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OnTimeShipping extends Mailable
{
    use Queueable, SerializesModels;

    public $report_generate;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($report_generate)
    {
        $this->report_generate = $report_generate;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // return $this->view('view.name');
        return $this->subject('Walmart On Time Shipping')->view('email.walmart_on_time_shipping');
    }
}
