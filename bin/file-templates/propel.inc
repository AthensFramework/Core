<?php

require_once dirname(__FILE__) . '/../settings.php';

return [
    'propel' => [
        'database' => [
            'connections' => [
                APPLICATION_NAME => [
                    'adapter'    => 'mysql',
                    'classname'  => "Propel\\Runtime\\Connection\\ConnectionWrapper",
                    'dsn'        => MYSQL_DSN,
                    'user'       => MYSQL_USER,
                    'password'   => MYSQL_PASSWORD,
                    'attributes' => []
                ]
            ]
        ],
        'runtime' => [
            'defaultConnection' => APPLICATION_NAME,
            'connections' => [APPLICATION_NAME]
        ],
        'generator' => [
            'defaultConnection' => APPLICATION_NAME,
            'connections' => [APPLICATION_NAME]
        ]
    ]
];