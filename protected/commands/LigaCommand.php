<?php
class LigaCommand extends CConsoleCommand {
    public function run($args) {
        // Borra todos los partidos ya jugados
        Partidos::limpiarTerminados();

        // Crea una nueva liga
        $horas = array(0.0, 0.25, 0.5, 0.75);

        Yii::import('application.controllers.ScriptsController');
        ScriptsController::generaLiga(null, -1, null, $horas, 3600);
    }
}
