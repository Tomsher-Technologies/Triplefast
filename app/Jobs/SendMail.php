<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Mail\MailSend;
use Mail;

class SendMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    protected $user;
    protected $mailContent;

    public function __construct($user,$mailContent)
    {
        $this->user = $user;
        $this->mailContent = $mailContent;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $email = new MailSend($this->user,$this->mailContent);
        Mail::to($this->user['email'])->send($email);
    }
}
