<?php

return [
    'roles' => [
        'admin' => [
            'view all teams',
            'view teams',
            'create team',
            'edit team',
            'delete team',
            'disband team',
            'add people',
            'remove people',
            'create survey',
            'edit survey',
            'remove survey',
        ],
        'teamleader' => [
            'view teams',
            'edit team',
            'disband team',
            'add people',
            'remove people',
            'view surveys',
            'edit survey',
            'remove survey',
        ],
        'member' => [
            'view teams',
            'leave team',
            'view surveys',
            'take surveys',
        ],
        'guest' => [
            'view teams',
            'create team',
        ],
    ],
];
