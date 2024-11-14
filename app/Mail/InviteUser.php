<?php

namespace App\Mail;

use App\Models\Team;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class InviteUser extends Mailable
{
    use Queueable;
    use SerializesModels;

    public function __construct(
        public Team $team,
        public $email,
        public $inviteUrl
    ) {
        $this->email = $email;
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
        return [
            Attachment::fromUrl($this->team->defaultTeamAvatar())
        ];
    }
}
