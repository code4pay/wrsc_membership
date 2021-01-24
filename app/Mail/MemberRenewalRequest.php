<?php

namespace App\Mail;

use App\Models\BackpackUser;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MemberRenewalRequest extends Mailable implements ShouldQueue //this email will use the queue always. 
{
    use Queueable, SerializesModels;
    public $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(BackpackUser $user)
    {
          $this->user = $user;
          
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $curDir = dirname(__FILE__);
        $presidents_report = $curDir.'/../../storage/app/private/documents/presidents_report_2020.pdf';
        return $this->markdown('membership_renewal.email_renewal_request')
        ->from(config('app.send_renewals_from'))
        ->bcc(config('app.bcc_emails_to'))
        ->attach($presidents_report)
        ->subject('WRSC Membership Renewal')
        ;
    }
}