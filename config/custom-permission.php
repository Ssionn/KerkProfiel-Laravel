<?php

return [
    'roles' => [
        'admin' => [
            'create team',
            'edit team',
            'delete team',
            'add people',
            'remove people',
            'create survey',
            'edit survey',
            'remove survey',
        ],
        'teamleader' => [
            'view teams',
            'edit team',
            'delete team',
            'add people',
            'remove people',
            'view surveys',
            'create survey',
            'edit survey',
            'remove survey',
        ],
        'member' => [
            'view teams',
            'view surveys',
            'take surveys',
        ],
        'guest' => [
            'view teams',
            'create team',
        ]
    ],
];
