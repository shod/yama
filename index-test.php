<?php
// change the following paths if necessary
$yii=dirname(__FILE__).'/../framework/yii.php';
$yiiEx  = dirname(__FILE__) . '/protected/YiiBaseEx.php';
$config=dirname(__FILE__).'/protected/config/test.php';

if(YII_DEBUG === true){
    include_once 'functions.php';
}

function autoload($className){
    $className = ucfirst($className);
    return YiiBase::autoload($className);
}

require_once($yii);
require_once($yiiEx);

$yii = Yii::createWebApplication($config);
spl_autoload_unregister(array('YiiBase', 'autoload'));
spl_autoload_register(array('YiiBaseEx', 'autoload'));
$yii->run();