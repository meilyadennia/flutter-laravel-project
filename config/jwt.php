<?php

return [

    'secret' => env(
        'JWT_SECRET',
        'default-secret'
    ),

    'ttl' => (int) env(
        'JWT_TTL',
        3600
    ),

];