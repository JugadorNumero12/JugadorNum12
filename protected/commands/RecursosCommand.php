<?php

class RecursosCommand extends CConsoleCommand{

	function run($args){
		//no sé si debe comprobar si hay otro script ejecutandose o no
		$trans = Yii::app()->db->beginTransaction();
		try{
			$recursos=Recursos::model()->findAll();
			foreach ($recursos as $recurso) {
				//influencias
				Recursos::aumentar_recursos($recurso->usuarios_id_usuario, "influencias", $recurso->influencias_gen);
				//dinero
				Recursos::aumentar_recursos($recurso->usuarios_id_usuario, "dinero", $recurso->dinero_gen);
				//animo
				Recursos::aumentar_recursos($recurso->usuarios_id_usuario, "animo", $recurso->animo_gen);
				$trans->commit();
			}
		}catch(Exception $e){
			$trans->rollback();
		}
	}
}

?>