<?php

// change the following paths if necessary
$config=dirname(__FILE__).'/config/console.php';
defined('YII_DEBUG') or define('YII_DEBUG',false);

if (YII_DEBUG === true) {
    include_once dirname(__FILE__).'/../../core/functions.php';
}
defined('STDIN') or define('STDIN', fopen('php://stdin', 'r'));

require_once(dirname(__FILE__).'/../../framework/yii.php');
require_once(dirname(__FILE__) . '/../../core/YiiBaseEx.php');


Yii::setPathOfAlias("core", dirname(__FILE__).'/../../core_ek');
Yii::getLogger()->autoDump = true;
Yii::getLogger()->autoFlush=1;
if(isset($config))
{
	$app=Yii::createConsoleApplication($config);
	$app->commandRunner->addCommands(YII_PATH.'/cli/commands');
}
else
	$app=Yii::createConsoleApplication(array('basePath'=>dirname(__FILE__).'/cli'));

spl_autoload_unregister(array('YiiBase', 'autoload'));
spl_autoload_register(array('YiiBaseEx', 'autoload'));



$env=@getenv('YII_CONSOLE_COMMANDS');
if(!empty($env))
	$app->commandRunner->addCommands($env);

$app->run();