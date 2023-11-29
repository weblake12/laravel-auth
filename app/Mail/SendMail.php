<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }

    /**
     * Create a new message instance.
     *
     * @return void
     */

    public function __construct() {
 
    }
 
     /**
      * Build the message.
      *
      * @return $this
      */
    public function build() {
        return $this->subject(__('Test sending'))->markdown('mail.test_email');
    }
}
