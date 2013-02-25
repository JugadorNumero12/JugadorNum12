<?php
class TestCommand extends CConsoleCommand {
    public function run($args) {
        // here we are doing what we need to do
        $mod = Usuarios:: model()->findByPk(9);
                $mod->nivel += 3;
                $mod->save();
    }
}
?>