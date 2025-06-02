<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class JobApplicationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $job;
    public $resumePath;

    /**
     * Create a new message instance.
     */
    public function __construct($user, $job, $resumePath)
    {
        $this->user = $user;
        $this->job = $job;
        $this->resumePath = $resumePath;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('New Job Application')
                    ->view('email.job_application')  // This must match the Blade file path
                    ->with([
                        'user' => $this->user,
                        'job' => $this->job,
                        'resumePath' => $this->resumePath,
                        'employer' => $this->job->user
                    ]);
    }
}
