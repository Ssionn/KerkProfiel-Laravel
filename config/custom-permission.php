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
        'team' => [
            'view teams',
            'edit own team',
            'view surveys',
        ],
        'member' => [
            'create team',
            'view teams',
            'take surveys',
        ],
    ],
];
