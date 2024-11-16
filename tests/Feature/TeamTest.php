<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\Team;
use App\Models\User;

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertDatabaseMissing;

test('database has seeded users and teams', function () {
    assertDatabaseHas('users', [
        'username' => 'Casper Kizewski',
        'email' => 'casper@houseofhope.com',
    ]);

    assertDatabaseHas('teams', [
        'name' => 'Development Team',
        'description' => 'The team which develops this product',
    ]);
});

test('team has an owner relationship', function () {
    $team = Team::first();

    expect($team->owner)->toBeInstanceOf(User::class);

    assertDatabaseHas('teams', [
        'id' => $team->id,
        'user_id' => $team->owner->id,
    ]);
});

test('team has members with correct roles', function () {
    $team = Team::first();
    $memberRole = Role::where('name', 'member')->first();

    assertDatabaseHas('teams', [
        'id' => $team->id,
    ]);

    assertDatabaseHas('users', [
        'id' => $team->users->first()->id,
        'role_id' => $memberRole->id,
    ]);
});

test('team owner can remove a user from team', function () {
    $team = Team::first();
    $userToRemove = $team->users->first();

    $teamId = $team->id;
    $userId = $userToRemove->id;

    $response = $this->actingAs($team->owner)
        ->from('/teams')
        ->delete("/teams/{$userToRemove->id}/remove");

    expect($response->getStatusCode())->toBe(302);

    $response->assertRedirect('/teams');

    assertDatabaseMissing('teams', [
        'id' => $teamId,
        'user_id' => $userId,
    ]);

    assertDatabaseHas('users', [
        'id' => $userId,
    ]);
});

test('non-owner cannot remove user from team', function () {
    $team = Team::first();
    $regularUser = $team->users->first();
    $userToRemove = User::orderBy('id', 'desc')
        ->where('team_id', $team->id)
        ->first();

    $response = $this->actingAs($regularUser)
        ->from('/teams')
        ->delete("/teams/{$userToRemove->id}/remove");

    expect($response->getStatusCode())->toBe(403);

    $response->assertStatus(403);

    assertDatabaseHas('teams', [
        'id' => $team->id,
        'user_id' => $userToRemove->id,
    ]);
});
