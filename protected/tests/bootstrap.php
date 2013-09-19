<?php
$yiit = dirname(__FILE__) . '/../../../framework/yiit.php';
$yiiEx  = dirname(__FILE__) . '/../YiiBaseEx.php';
$config = dirname(__FILE__) . '/../config/test.php';

require_once($yiit);
//require_once 'PHPUnit/Autoload.php';
require_once dirname(__FILE__) . '/../../../framework/test/CTestCase.php';
Yii::setPathOfAlias("api", dirname(__FILE__).'/../modules/api');
require_once(dirname(__FILE__).'/WebTestCase.php');

$yiiEx  = dirname(__FILE__) . '/../../../core/YiiBaseEx.php';

function autoload($className){
    $className = ucfirst($className);
    return YiiBase::autoload($className);
}

include_once dirname(__FILE__) . '/../../../core/functions.php';

require_once($yiiEx);
Yii::setPathOfAlias("core", dirname(__FILE__).'/../../../core');
Yii::createWebApplication($config);
spl_autoload_unregister(array('YiiBase', 'autoload'));
spl_autoload_register(array('YiiBaseEx', 'autoload'));
