<?php

return CMap::mergeArray(
	require(dirname(__FILE__).'/local.php'),
	array(
            'import' => array(
                'application.models.*',
                'api.models.*',
                'api.components.*',
                'api.controllers.*',
            ),
            'modules' => array(
                'api',
            ),
            'params' => array('api' => array(
                    'key' => 'devel',
                    'suid' => '3da7b280eda538c15f2bff38afd11dcd',
                    'user_puid' => 'asd',
                    'user_id' => 100,
                ),
            ),
	)
);
