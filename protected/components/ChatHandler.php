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
        return hash('sha1',$this->getChatId().time().rand(1000,9999));      
    }
    protected function getIdentityName(){
        // find the identity name here
        // example: 
        //  $model = MyPeople::model()->findByPk($this->getIdentity());
        //  return $model->userFullName();
        return "jhonn doe"; 
    }
    protected function getDateFormatted($value){
        // format the date numeric $value
        return Yii::app()->format->formatDateTime($value);
    }
    protected function acceptMessage($message){
        // return true for accept this message. false reject it.
        return true;
    }
}
?>