<?php
	define('YII_DEBUG',true);
// change the following paths if necessary
$yii=dirname(__FILE__).'/../framework/yii.php';
$yiiEx  = dirname(__FILE__) . '/../core/YiiBaseEx.php';
$config=dirname(__FILE__).'/protected/config/local.php';

// remove the following lines when in production mode
defined('YII_DEBUG') or define('YII_DEBUG',true);
// specify how many levels of call stack should be shown in each log message
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);

if(YII_DEBUG === true){
	ini_set('error_reporting', E_ALL);
	ini_set('display_errors', 1);
}
include_once '../core/functions.php';
function autoload($className){
    $className = ucfirst($className);
    return YiiBase::autoload($className);
}

require_once($yii);
require_once($yiiEx);

Yii::setPathOfAlias("core", dirname(__FILE__).'/../core');
$yii = Yii::createWebApplication($config);
spl_autoload_unregister(array('YiiBase', 'autoload'));
spl_autoload_register(array('YiiBaseEx', 'autoload'));
//Yii::getLogger()->autoDump = true;
//Yii::getLogger()->autoFlush=1;

if(isset($_GET['profiling'])){
	define('XHPROF_LIB_ROOT', dirname(__FILE__) .  "/xhprof-master/xhprof_lib");

	ini_set('display_errors','On'); 
	error_reporting(E_ALL);


	xhprof_enable(XHPROF_FLAGS_CPU + XHPROF_FLAGS_MEMORY);

	$yii->run();

	$xhprof_data = xhprof_disable();

	$XHPROF_ROOT = "xhprof-master";
	include_once $XHPROF_ROOT . "/xhprof_lib/config.php";
	include_once $XHPROF_ROOT . "/xhprof_lib/utils/xhprof_lib.php";
	include_once $XHPROF_ROOT . "/xhprof_lib/utils/xhprof_runs.php";

	$xhprof_runs = new XHProfRuns_Default();
	$run_id = $xhprof_runs->save_run($xhprof_data, "xhprof_testing");

	echo "http://sell.ek.dev.migom.by/xhprof-master/xhprof_html/index.php?run={$run_id}&source=xhprof_testing\n";
} else {
	$yii->run();
}








