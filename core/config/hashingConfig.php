<?php

return [

    //Suported bcrypt, argon, argon2id

    'driver' => 'argon',

    'bcrypt' => [
        'cost' => 10
    ],

    'argon' => [
        'memory' => 1024,
        'threads' => 2,
        'time' => 2
    ]

];
