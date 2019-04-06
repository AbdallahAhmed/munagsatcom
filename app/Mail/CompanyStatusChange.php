<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class CompanyStatusChange extends Mailable
{
    use Queueable, SerializesModels;

    public $company;

    public $status;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($company, $newStatus)
    {
        //
        $this->company = $company;
        $this->status = $newStatus;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('info@munagasatcom.com', 'مناقصاتكم |' . $this->company->name)
            ->view('mail.verification', ['company' => $this->company, 'status' => $this->status]);
    }
}
