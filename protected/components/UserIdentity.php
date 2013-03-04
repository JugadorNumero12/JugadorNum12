<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
	//Necesario definir el elemento id
    private $_id;

    public function authenticate()
    {
        $record = Usuarios::model()->findByAttributes(array('nick'=>$this->username));

        if ($record === null) {
            $this->errorCode = self::ERROR_USERNAME_INVALID;

        } else if (!$record->comprobarClave($this->password)) {
            $this->errorCode = self::ERROR_PASSWORD_INVALID;

        } else {
            $this->_id = $record->id_usuario; 
            //Variable Yii::app()->user->usIdent           
            $this->setState('usIdent', $record->id_usuario);
            //Variable Yii::app()->user->usAfic 
            $this->setState('usAfic', $record->equipos_id_equipo);
            $this->errorCode = self::ERROR_NONE;
        }

        return !$this->errorCode;
    }
 
    public function getId()
    {
        return $this->_id;
    }
}