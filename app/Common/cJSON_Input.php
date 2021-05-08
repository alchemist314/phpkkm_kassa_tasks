<?php

namespace phpKKM\app\Common;

/**
 * cJSON 
 */

class cJSON_Input
{
    /**
     * 
     * @return JSON Object
     */
    public static function fGetJSON_Input()
    {
	// Дешифруем входящие данные
	$oJSON_DATA = json_decode(urldecode(file_get_contents('php://input')));
	$a=var_export($oJSON_DATA,true);

	if (!empty($oJSON_DATA)) {
	    return $oJSON_DATA;
	}
    }
}

?>