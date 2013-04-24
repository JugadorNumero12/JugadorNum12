<?php
class ChatHandler extends YiiChatDbHandlerBase {
    //
    // IMPORTANT:
    // in any time here you can use this available methods:
    //  getData(), getIdentity(), getChatId()
    //
    protected function getDb(){
        // the application database
        return Yii::app()->db;
    }
    protected function createPostUniqueId(){
        // generates a unique id. 40 char.
        //NO SE UTILIZA
        //return hash('sha1',$this->getChatId().time().rand(1000,9999));
        return hash('sha1',$this->getChatId().time());     
    }
    protected function getIdentityName(){
        // the name shown
        $id = Yii::app()->user->usIdent;
        $model = Usuarios::model()->findByPk($id);
        return $model->nick; 
    }
    protected function getDateFormatted($value){
        // format the date numeric $value
        //return Yii::app()->format->formatDateTime($value);
        return date("H:i",$value); //Muestro solo la hora y los minutos
    }
    protected function acceptMessage($message){
        // return true for accept this message. false reject it.
        //return true;
        return $message;
    }
}
?>