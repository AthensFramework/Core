<?php

return [
    'propel' => [
        'database' => [
            'connections' => [
                'athens_test' => [
                    'adapter'    => "mysql",
                    'classname'  => "Propel\\Runtime\\Connection\\ConnectionWrapper",
                    'dsn'        => "dsn",
                    'user'       => "user",
                    'password'   => "password",
                    'attributes' => []
                ]
            ]
        ],
        'runtime' => [
            'defaultConnection' => 'athens_test',
            'connections' => ['athens_test']
        ],
        'generator' => [
            'defaultConnection' => 'athens_test',
            'connections' => ['athens_test']
        ]
    ]
];