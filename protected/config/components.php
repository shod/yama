<?php

return array(
    'db'            => require(dirname(__FILE__) . '/components/db.php'),
    'mongodb'       => require(dirname(__FILE__) . '/components/mongodb.php'),
    'session'       => require(dirname(__FILE__) . '/components/session.php'),
    'eauth'         => require(dirname(__FILE__) . '/components/eauth.php'),
    'cache'         => require(dirname(__FILE__) . '/components/cache.php'),
    'widgetFactory' => require(dirname(__FILE__) . '/components/widgetFactory.php'),
    'migom'         => require(dirname(__FILE__) . '/components/migom.php'),
	'tags'          => require(dirname(__FILE__) . '/components/tags.php'),
	'social'        => require(dirname(__FILE__) . '/components/social.php'),
    'log'           => require(dirname(__FILE__) . '/components/log.php'),
	'fileCache'		=> require(dirname(__FILE__) . '/components/fileCache.php'),
	'notify' => array(
		'class' => 'core.components.QUserNotify',
	),
    'image' => array(
        'class' => 'core.extensions.image.CImageComponent',
        // GD or ImageMagick
        'driver' => 'GD',
        // ImageMagick setup path
        'params' => array('directory' => '/opt/local/bin'),
    ),
    'messages' => array(
        'class'=>'CPhpMessageSource',
        'basePath' => '../core/messages'
    ),
    'user' => array(
        // enable cookie-based authentication
        'allowAutoLogin' => false,
        'class' => 'WebUser',
        'loginUrl' => array('login'),
        'defaultRole' => 'guest',
    ),
    'authManager' => array(
        'class' => 'PhpAuthManager',
        'defaultRoles' => array('guest'),
    ),
	'mailer' => array(
        'class' => 'core.extensions.mailer.EMailer',
        'pathViews' => 'core.extensions.mailer..email',
        'pathLayouts' => 'core.extensions.mailer.layouts',
//                    'Host'          => 'SMTP HOST',
//                    'SMTPAuth'      => true,
//                    'Username'      => 'yourname@163.com',
//                    'Password'      => 'yourpassword',
        'From'   	=> 'noreply@social.migom.by',
		'Sender' 	=> 'noreply@social.migom.by',
		'CharSet' 	=> 'UTF-8',
		'Hostname' 	=> 'social.migom.by',
		
    ),
    // uncomment the following to enable URLs in path-format
    'urlManager' => array(
        'urlFormat' => 'path',
        'showScriptName' => false,
        'rules' => array(
            'api' => 'api/default/index',
            'ads' => 'ads/default/index',
            '' => 'site/index',
			'ahimsa/<id:\d+>' => 'ahimsa/view',
            '<controller:\w+>/<id:\d+>' => '<controller>/view',
            '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
            '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
			'<controller:\w+>/<action:\w+>/<url>' => '<controller>/<action>',
			'<query>' => 'site/index',
        ),
    ),
    'request' => array(
        'class' => 'HttpRequest'
    ),
    'errorHandler' => array(
        // use 'site/error' action to display errors
        'errorAction' => 'site/error',
    ),
    'loid' => array(
        'class' => 'ext.lightopenid.loid',
    ),
);