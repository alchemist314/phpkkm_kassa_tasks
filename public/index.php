<?php

/**
 * Данный скрипт располагается на платежном сервере, создает задания и ожидает сообщения от кассы
 *
*/

use phpKKM\app\Common\cLogger;
use phpKKM\app\Common\cJSON_Input;
use phpKKM\app\Common\cModel;
use phpKKM\app\Common\cRouter;
use phpKKM\app\Model\cAuthModel;
 
// Конфигурационный файл
require_once "../app/Config/Config.php";

// Автозагрузка классов
require_once(PHPKKM_ROOT.'/app/Functions/fAutoload.php');

// Инициализируем обьекты
require_once PHPKKM_ROOT.'/app/Includes/init.php';

// Получаем входящий обьект JSON
$oJSON_Data = cJSON_Input::fGetJSON_Input();

// Авторизация
if (cAuthModel::fAuth($oJSON_Data->login, $oJSON_Data->passwd)) {

    // Разбираем параметры запроса
    $oRouter = new cRouter();
    $oRouter->fRun($oJSON_Data);
}


?>