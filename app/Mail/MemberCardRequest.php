<?php

namespace App\Mail;

use App\Models\BackpackUser;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use PDF;

class MemberCardRequest extends Mailable  //this email will use the queue always. 
{
    use Queueable, SerializesModels;
    public $user;
    public $pdf;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(BackpackUser $user)
    {
          $this->user = $user;
          $this->pdf = PDF::loadView('membership_card.membership_card', ['users' => [$user]])->output();
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.member.membership_card')
        ->attachData($this->pdf, 'wrsc_membership_card.pdf',['mime' => 'application/pdf'])
        ->subject('WRSC Membership Card')
        ->bcc(config('app.bcc_emails_to'))
        ->from(config('app.send_renewals_from'));
    }
}