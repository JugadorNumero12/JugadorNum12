<?php

// Framework path
$yiis=array(
    dirname(__FILE__).'/framework/yii.php',
    dirname(__FILE__).'/../framework/yii.php'
);
foreach ($yiis as $v) {
    if (is_file($v)) {
        $yii=$v;
    }
}
// Config file path
$config=dirname(__FILE__).'/protected/config/main.php';

// remove the following lines when in production mode
defined('YII_DEBUG') or define('YII_DEBUG',true);
// specify how many levels of call stack should be shown in each log message
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);

require_once($yii);
Yii::createWebApplication($config)->run();
