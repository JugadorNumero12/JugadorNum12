<?php
class NotificacionesCommand extends CConsoleCommand {
    public function run($args) {
        // here we are doing what we need to do
       Notificaciones::model()->borrarNotificaciones();
       // //00 05 * * 01 /opt/lampp/bin/php /opt/lampp/htdocs/yii/JugadorNum12/cron.php notificaciones >/dev/null
    }
}
