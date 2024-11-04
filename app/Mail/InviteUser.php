<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class InviteUser extends Mailable
{
    use Queueable, SerializesModels;

    public $email;
    public $inviteToken;
    public $teamName;
    public $inviteUrl;

    public function __construct($email, $inviteToken, $teamName, $inviteUrl)
    {
        $this->email = $email;
        $this->inviteToken = $inviteToken;
        $this->teamName = $teamName;
        $this->inviteUrl = $inviteUrl;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Uitnodiging om lid te worden',
            from: config('mail.from.address'),
            replyTo: [
                config('mail.from.address'),
            ],
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.invite',
            with: [
                'email' => $this->email,
                'inviteToken' => $this->inviteToken,
                'teamName' => $this->teamName,
                'url' => $this->inviteUrl,
            ],
        );
    }

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
