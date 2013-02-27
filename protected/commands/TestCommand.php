<?php
class TestCommand extends CConsoleCommand {
    public function run($args) {
        // here we are doing what we need to do
        $trans = Yii::app()->db->beginTransaction();
		try{
        $mod = Usuarios:: model()->findByPk(9);
                $mod->nivel += 3;
                $mod->save();
                $trans->commit();
        catch(Exception $e){
			$trans->rollback();
        }
    }
}
?>