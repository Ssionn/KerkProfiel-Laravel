<?php

return [
    'roles' => [
        'admin' => [
            'view teams',
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
            'edit own team',
            'view surveys',
        ],
        'member' => [
            'view teams',
            'take surveys',
        ],
        'guest' => [
            'create teams',
            'view surveys',
        ],
    ],
];
