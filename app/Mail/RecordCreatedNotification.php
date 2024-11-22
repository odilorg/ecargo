<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RecordCreatedNotification extends Mailable
{
    use Queueable, SerializesModels;
    public $user;
    public $package;

    /**
     * Create a new message instance.
     */
    public function __construct($user, $package)
    {
        $this->user = $user;
        $this->package = $package;
    }
    public function build()
    {
        return $this->subject('New Record Created')
                    ->view('emails.record_created')
                    ->with([
                        'user' => $this->user,
                        'package' => $this->package,
                    ]);
    }
    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Record Created Notification',
        );
    }

    /**
     * Get the message content definition.
     */
    

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
