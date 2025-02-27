<?php

namespace Database\Seeders;

use App\Models\Team;
use Illuminate\Database\Seeder;

class TeamsSeeder extends Seeder
{
    public function run(): void
    {
        Team::create([
            'id' => 1,
            'name' => 'Development Team',
            'description' => 'The team which develops this product',
            'avatar' => null,
            'owner_id' => null,
        ]);
    }
}
