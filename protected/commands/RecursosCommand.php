<?php

class RecursosCommand extends CConsoleCommand{

	function run($args){
		//no sé si debe comprobar si hay otro script ejecutandose o no
		$trans = Yii::app()->db->beginTransaction();
		try{
			$recursos=Recursos::model()->findAll();
			$help=new Helper;
			foreach ($recursos as $recurso) {
				//influencias
				$help->aumentar_recursos($recurso->usuarios_id_usuario, "influencias", $recurso->influencias_gen);
				//dinero
				$help->aumentar_recursos($recurso->usuarios_id_usuario, "dinero", $recurso->dinero_gen);
				//animo
				$help->aumentar_recursos($recurso->usuarios_id_usuario, "animo", $recurso->animo_gen);
				$trans->commit();
			}
		}catch(Exception $e){
			$trans->rollback();
		}
	}
}

?>