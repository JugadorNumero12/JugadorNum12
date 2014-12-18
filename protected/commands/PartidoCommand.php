<?php
class PartidoCommand extends CConsoleCommand
{
    public function run($args)
    {
        //Ejecutamos un turno de partido
        /*Yii::import('application.components.*');
        Yii::import('application.models.*');

        $tiempo=time();
        $primerTurno=Partido::PRIMER_TURNO;
        $ultimoTurno=Partido::ULTIMO_TURNO;
        $busqueda=new CDbCriteria;
        $busqueda->addCondition(':bTiempo >= hora');
        $busqueda->addCondition('turno >= :bPrimerTurno');
        $busqueda->addCondition('turno <= :bUltimoTurno');
        $busqueda->params = array(':bTiempo' => $tiempo,
                                ':bPrimerTurno' => $primerTurno,
                                ':bUltimoTurno' => $ultimoTurno);
        $partidos=Partidos::model()->findAll($busqueda);

        foreach ($partidos as $partido)
        {
            $transaction = Yii::app()->db->beginTransaction();
            try
            {
                $partido = new Partido($partido->id_partido);
                $partido->jugarse();
                $transaction->commit();
            }
            catch (Exception $ex)
            {
                $transaction->rollback();
                throw $ex;
            }
        }*/
        Yii::import('application.controllers.ScriptsController');
        ScriptsController::ejecutarTurno();
    }
}
?>