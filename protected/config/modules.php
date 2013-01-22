<?php

return array(
    // uncomment the following to enable the Gii tool
    'gii' => array(
        'class' => 'system.gii.GiiModule',
        'password' => 'pass',
        // If removed, Gii defaults to localhost only. Edit carefully to taste.
        'ipFilters' => array(
            '86.57.245.247',
            '::1',
            '127.0.0.1'),
    ),
    'api' => array(
        'keys' => array(
            'devel' => '86.57.245.247',
            'test3migomby' => '178.172.181.139',
            'migom' => '178.172.181.139',
            'test' => '127.0.0.1',
			'testmigomby' => '93.125.53.103',
        )
    ),
    'ads' => array(
        'ipFilters' => array(
            '86.57.245.247',
            '::1',
            '127.0.0.1'),
    ),
);
?>
