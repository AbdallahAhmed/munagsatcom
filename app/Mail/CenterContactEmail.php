<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Http\Request;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class CenterContactEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $request = array();
    public $user = array();
    public $center = array();
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Request $request, $user, $center)
    {
        $this->request = $request;
        $this->user = $user;
        $this->center = $center;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('info@munagasatcom.com', 'Feedback')->subject('')->view('mail.centers_contact', ['request' => $this->request, 'user' => $this->user, 'center' => $this->center]);
    }
}
