<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendTokenMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data) {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build () {
        return $this->replyTo(config('app.email'))
                        ->subject(__('Reset password') . ' ' .  config('app.name'))
                            ->markdown('mail.reset_link_password')
                                ->with('data', $this->data);
    }
}
