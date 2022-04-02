<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MessageOfChange extends Mailable
{
    use Queueable;
    use SerializesModels;

    public $user;
    public $userChange;
    public $skillsChange;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $userChange, $skillsChange)
    {
        $this->user = $user;
        $this->userChange = $userChange;
        $this->skillsChange = $skillsChange;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('mails.message_of_change')
                    ->subject('Изменение в карточке сотрудника');
    }
}
