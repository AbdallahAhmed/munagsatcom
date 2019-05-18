<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class NewsLetters extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    /**
     * @var
     */
    public $tenders;

    /**
     * @var
     */
    public $count;

    public function __construct($tenders, $count)
    {
        //

        $this->tenders = $tenders;
        $this->count = $count;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('info@munagasatcom.com', 'منصة مناقصاتكم | دعوة خاصة')->view('mail.newsletter', ['tenders' => $this->tenders, 'count' => $this->count]);
    }
}
