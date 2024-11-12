<?php

return [
    'team_info' => [
        'role_position' => 'Teamleader',
    ],

    'team_members_table' => [
        'table_header' => 'Team leden',

        'table_filter' => [
            'all' => 'Alle',
            'teamleaders' => 'Teamleaders',
            'members' => 'Members',
            'no_users' => 'Geen gebruikers met de rol',
        ],

        'table_dropdown' => [
            'edit_team_save' => 'Team opslaan',
            'edit_team_button' => 'Team bewerken',
            'invite_members' => 'Mensen uitnodigen',
            'invite_fields' => [
                'email' => 'Email',
                'invite_button' => 'Versturen',
            ],
            'remove_user' => 'Verwijder gebruiker',
            'remove_user_button' => 'Verwijderen',
            'remove_user_confirm' => 'Weet je zeker dat je deze gebruiker wilt verwijderen?',
            'leave_team' => 'Verlaat team',
            'leave_team_button' => 'Verlaat team',
            'leave_team_confirm' => 'Weet je zeker dat je dit team wilt verlaten?',
        ],

        'table_column_headings' => [
            'name' => 'Naam',
            'email' => 'Email',
            'role' => 'Rol',
            'status' => 'Status',
            'remove' => 'Verwijderen',
        ],

        'table_user_activity' => [
            'active' => 'Actief',
            'inactive' => 'Inactief',
        ],
    ],
];
