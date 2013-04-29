<?php

return CMap::mergeArray(
	require(dirname(__FILE__).'/../../../core/config/main.php'),
	array(
        'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
        'runtimePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..'
        . DIRECTORY_SEPARATOR . 'runtime',
        'name' => 'Social Migom BY',
        // preloading 'log' component
        'preload' => array('log'),
        'defaultController' => 'site',
        'sourceLanguage' => 'ru_RU',
        'language' => 'ru',
        'components' => require(dirname(__FILE__) . '/components.php'),
        'import' => array(
            'core.models.api.*',
			'core.models.*',
            'application.models.*',
			'application.widgets.*',
            'core.models.mongo.*',
			'application.services.*',
            'core.components.*',
            'core.widgets.*',
            'core.services.*',
            'core.extensions.yiidebugtb.*',
            'core.extensions.eoauth.*',
            'core.extensions.eoauth.lib.*',
            'core.extensions.lightopenid.*',
            'core.extensions.eauth.*',
            'core.extensions.eauth.custom_services.*',
            'core.extensions.YiiMongoDbSuite.*',
            'core.extensions.YiiMongoDbSuite.extra.*',
            'core.extensions.yiiRestSuite.*',
            'core.extensions.yiiRestSuite.server.*',
        ),
        'modules' => require(dirname(__FILE__) . '/modules.php'),
		'params' => require(dirname(__FILE__) . '/params.php'),
	)

);
