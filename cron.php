<?php

/** 
 * Cron principal
 *
 * @package raiz
 */

// Framework path
$yii=dirname(__FILE__).'/../framework/yii.php';
// Config file path
$config=dirname(__FILE__).'/protected/config/cron.php';

// remove the following lines when in production mode
defined('YII_DEBUG') or define('YII_DEBUG',true);
// specify how many levels of call stack should be shown in each log message
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);

require_once($yii);
Yii::createConsoleApplication($config)->run();
