<?php

namespace phpKKM\app\Common;

use phpKKM\app\Common\cModel;
use phpKKM\app\Model\cTaskModel;

/**
 * Класс Router
 * Компонент для работы с маршрутами
 */
class cRouter
{
    /**
     * Свойство для хранения массива роутов
     * @var array 
     */
    private $aRoutes;

    /**
     * Конструктор
     */
    public function __construct()
    {

        // Путь к файлу с роутами
        $vRoutesPath = PHPKKM_ROOT.'/app/Config/Routes.php';
        // Получаем роуты из файла
        $this->aRoutes = include($vRoutesPath);
	
    }

    /**
     * Метод для обработки запроса
     */
    public function fRun($oJSON)
    {


        // Получаем команду action
        $vAction = $oJSON->action;
        // Получаем данные json
	$aParameters = json_decode(json_encode($oJSON->data),true);

        // Проверяем наличие такого запроса в массиве маршрутов (/Config/Routes.php)
        foreach ($this->aRoutes as $vPattern=>$vMethod) {

            // Сравниваем петтерн и строку запроса
            if (preg_match("~$vPattern~", $vAction)) {

		// Инициализируем обькт контроллера заданий
		$oModelObject = new cTaskModel();

                /* Вызываем необходимый метод ($vMethod) у определенного 
                 * класса ($oModelObject) с заданными ($aParameters) параметрами
                 */
		
                $vResult = call_user_func_array(array($oModelObject, $vMethod), array($aParameters));

                // Если метод контроллера успешно вызван, завершаем работу роутера
                if ($vResult != null) {
                    break;
                }
            }
        }
    }
}
?>