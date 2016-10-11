<?php
return [
    'manageUser' => [
        'type' => 2,
        'description' => 'Manage a user',
    ],
    'admin' => [
        'type' => 1,
        'children' => [
            'manageUser',
        ],
    ],
];
