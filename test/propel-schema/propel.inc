<?php

return [
    'propel' => [
        'database' => [
            'connections' => [
                'uwdoem_test' => [
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
            'defaultConnection' => 'uwdoem_test',
            'connections' => ['uwdoem_test']
        ],
        'generator' => [
            'defaultConnection' => 'uwdoem_test',
            'connections' => ['uwdoem_test']
        ]
    ]
];