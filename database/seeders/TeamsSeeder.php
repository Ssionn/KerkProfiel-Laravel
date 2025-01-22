<?php

namespace Database\Seeders;

use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Seeder;

class TeamsSeeder extends Seeder
{
    private readonly array $users;

    public function __construct()
    {
        $this->users = config('users.user_emails');
    }

    public function run(): void
    {
        $teamLeader = User::where('email', 'casper@houseofhope.com')->first();

        $team = Team::create([
            'id' => 1,
            'name' => 'Development Team',
            'description' => 'The team which develops this product',
            'avatar' => null,
            'owner_id' => $teamLeader->id,
        ]);

        User::query()
            ->whereIn('email', array_column($this->users, 'email'))
            ->update(['team_id' => $team->id]);

        foreach ($this->users as $user => $email) {
            User::where('email', $email)
                ->update(['team_id' => $team->id]);
        }
    }
}
