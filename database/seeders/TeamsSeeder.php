<?php

namespace Database\Seeders;

use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TeamsSeeder extends Seeder
{
    private array $emails;

    public function __construct()
    {
        $this->emails = config('emails.users');
    }

    public function run(): void
    {
        $devTeam = Team::create([
            'name' => 'Development Team',
            'description' => 'We work on the website.',
            'avatar' => 'null',
            'leader_id' => 1,
        ]);

        foreach ($this->emails as $email) {
            $userFound = $this->getUser($email[0]);

            $userFound->team_id = $devTeam->id;
            $userFound->save();

            setPermissionsTeamId($userFound->team_id);
            $userFound->assignRole('admin');
        }
    }

    private function getUser(string $email): User
    {
        return User::where('email', $email)->first();
    }
}
