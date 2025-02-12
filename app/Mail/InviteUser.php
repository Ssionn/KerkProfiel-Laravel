<?php

namespace App\Mail;

use App\Models\Team;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class InviteUser extends Mailable
{
    use Queueable;

    public function __construct(
        public Team $team,
        public string $inviteEmail,
        public string $acceptUrl
    ) {
    }

    public function build(): self
    {
        $mail = $this->view('emails.invite')
            ->with([
                'subject' => 'Uitnodiging',
                'team' => $this->team,
                'acceptUrl' => $this->acceptUrl,
            ]);

        /** @var ?Media $inviteTeamMedia */
        $inviteTeamMedia = $this->team->getFirstMedia('team_avatars');

        if ($inviteTeamMedia) {
            $thumbnailPath = $inviteTeamMedia->getPath('thumb');

            if (file_exists($thumbnailPath)) {
                $mail->attach($thumbnailPath, [
                    'as' => 'team-avatar.' . $inviteTeamMedia->extension,
                    'mime' => $inviteTeamMedia->mime_type,
                ]);
            }
        }

        return $mail;
    }
}
