<?php

namespace phpKKM\app\Model;

use phpKKM\app\Common\cModel;
use phpKKM\app\Classes\cSanitizer;

/**
 * Модель cAuthModel
 */

class cAuthModel extends cModel {

    /**
     * Авторизация
     *
     * @param string $vLogin, $vPasswd - логин, пароль.
     *
     * @return bool
     */
    public function fAuth($vLogin, $vPasswd) {
    
	// Очищаем переменные
	$vLogin = cSanitizer::fSanitize($vLogin, 100);
	$vPasswd = cSanitizer::fSanitize($vPasswd, 2000, 'all');

	return (($vLogin==PHPKKM_LOGIN) && ($vPasswd==PHPKKM_PASSWD)) ? true : false;


    }
}

?>