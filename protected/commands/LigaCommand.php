<?php
class LigaCommand extends CConsoleCommand {
    public function run($args) {
        // Borra todos los partidos ya jugados
        Partidos::limpiarTerminados();

        // Crea una nueva liga
        $horas = array(
            // 14 horas: de 8 a 22 (9 a 23 en verano)
            7,  7.25,  7.5,  7.75,
            8,  8.25,  8.5,  8.75,
            9,  9.25,  9.5,  9.75,
            10, 10.25, 10.5, 10.75,
            11, 11.25, 11.5, 11.75,
            12, 12.25, 12.5, 12.75,
            13, 13.25, 13.5, 13.75,
            14, 14.25, 14.5, 14.75,
            15, 15.25, 15.5, 15.75,
            16, 16.25, 16.5, 16.75,
            17, 17.25, 17.5, 17.75,
            18, 18.25, 18.5, 18.75,
            19, 19.25, 19.5, 19.75,
            20, 20.25, 20.5, 20.75,
        );

        Yii::import('application.controllers.ScriptsController');
        ScriptsController::generaLiga(null, 0, null, $horas, 3600);
    }
}
