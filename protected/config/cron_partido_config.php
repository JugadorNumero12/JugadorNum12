<?php
return array(
        'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
        'name'=>'CronPartido',
        'preload'=>array('log'),
         'import'=>array(
                'application.components.*',
                'application.models.*',
        ),
        // application components
        'components'=>array(
                'db'=>array(
                    'connectionString' =>
                        'mysql:host='
                      . getenv('OPENSHIFT_MYSQL_DB_HOST')
                      . ':'
                      . getenv('OPENSHIFT_MYSQL_DB_PORT')
                      . ';dbname=jn12',
                    'emulatePrepare' => true,
                    'username' => getenv('OPENSHIFT_MYSQL_DB_USERNAME'),
                    'password' => getenv('OPENSHIFT_MYSQL_DB_PASSWORD'),
                    'charset' => 'utf8',
        //          'tablePrefix' => 'j12_'
                ),
                'log'=>array(
                        'class'=>'CLogRouter',
                        'routes'=>array(
                                array(
                                        'class'=>'CFileLogRoute',
                                        'logFile'=>'cron.log',
                                        'levels'=>'error, warning',
                                ),
                                array(
                                        'class'=>'CFileLogRoute',
                                        'logFile'=>'cron_trace.log',
                                        'levels'=>'trace',
                                ),
                        ),
                ),
                'functions'=>array(
                        'class'=>'application.extensions.functions.Functions',
                ),
        ),
);
