<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewOpportunityMail extends Mailable
{
    use Queueable, SerializesModels;

    public $opportunityTitle;
    public $opportunityLink;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($opportunityTitle, $opportunityLink)
    {
        $this->opportunityTitle = $opportunityTitle;
        $this->opportunityLink = $opportunityLink;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Conexões Engenharia - Uma nova oportunidade para aprovação!')
            ->view('emails.new_opportunity')
            ->with([
                'opportunityTitle' => $this->opportunityTitle,
                'opportunityLink' => $this->opportunityLink,
            ]);
    }
}
