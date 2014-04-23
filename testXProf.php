<?php
define('XHPROF_LIB_ROOT', dirname(__FILE__) .  "/xhprof-master/xhprof_lib");

ini_set('display_errors','On'); 
error_reporting(E_ALL);


xhprof_enable(XHPROF_FLAGS_CPU + XHPROF_FLAGS_MEMORY);

for ($i = 0; $i <= 1000; $i++) {
    $a = $i * $i;
}

$xhprof_data = xhprof_disable();

$XHPROF_ROOT = XHPROF_LIB_ROOT;
include_once $XHPROF_ROOT . "/config.php";
include_once $XHPROF_ROOT . "/utils/xhprof_lib.php";
include_once $XHPROF_ROOT . "/utils/xhprof_runs.php";

$xhprof_runs = new XHProfRuns_Default();
$run_id = $xhprof_runs->save_run($xhprof_data, "xhprof_testing");

echo "http://sell.ek.dev.migom.by/xhprof-master/xhprof_html/index.php?run={$run_id}&source=xhprof_testing\n";
?>