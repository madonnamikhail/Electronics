<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class sendMail extends Mailable
{
    use Queueable, SerializesModels;
    public $orderInsert;

    public $products;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($orderInsert, $products)
    {
        $this->orderInsert = $orderInsert;
        $this->products = $products;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Mail from Electronics Website')->view('front.mail-view');

    }
}
