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
        $team = Team::create([
            'id' => 1,
            'name' => 'Development Team',
            'description' => 'The team which develops this product',
            'avatar' => null,
            'user_id' => User::where('email', 'casper@houseofhope.com')->value('id'),
        ]);

        User::query()
            ->whereIn('email', array_column($this->users, 'email'))
            ->whereNotIn('role_id', [1])
            ->update(['team_id' => $team->id]);

        foreach ($this->users as $user => $email) {
            User::where('email', $email)
                ->orWhere('role_id', '!=', 1)
                ->update(['team_id' => $team->id]);
        }
    }
}
