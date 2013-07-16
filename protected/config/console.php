<?php

// This is the configuration for yiic console application.
// Any writable CConsoleApplication properties can be configured here.
return array(
    'import' => array(
        'core.models.api.*',
        'application.models.*',
        'core.services.*',
        'application.models.mongo.*',
        'core.components.*',
        'core.components.ConsoleCommand',
        'core.extensions.yiiRestSuite.*',
        'core.extensions.YiiMongoDbSuite.*',
        'core.extensions.YiiMongoDbSuite.extra.*',
		'core.extensions.siteMapRenderer.*',
    ),
	'preload'=>array('log'),
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'name' => 'Social Migom By Console',
    'modules' => require(dirname(__FILE__) . '/modules.php'),
    'components' => require(dirname(__FILE__) . '/components.php'),
    'params' => array(
        'mail' => array(
            'time_limit' => 50 // время отработки воркера (обновление в кроне - раз в минуту)
        ),
        'likes' => array(
            'time_limit' => 60 * 9 // 9 минут на обновление лайков (обновление в кроне - раз в 10 минут)
        ),
		'socialBaseUrl' => 'http://www.social.migom.by/',
		'yamaBaseUrl' => 'http://www.yama.migom.by/',
    ),

);