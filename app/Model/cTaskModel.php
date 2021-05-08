<?php

namespace phpKKM\app\Model;

use phpKKM\app\Classes\cSanitizer;
use phpKKM\app\Common\cLogger;
use phpKKM\app\Common\cModel;

/**
 * Модель cTaskModel
 */

class cTaskModel extends cModel {

    /**
     * Получить задания
     *
     * @return json
     */
    public function fGetTasks() {
	if (PHPKKM_STORAGE=='DIR') {
	    //Забираем задания из директории
	    $aDir = scandir(PHPKKM_TASKS_DIR);
	    for($l=0; $l<count($aDir); $l++) {
		$vFilePath=PHPKKM_TASKS_DIR."/".$aDir[$l];
		if (is_file($vFilePath)) {
    		    $aTaskArray[$aDir[$l]]=file_get_contents($vFilePath);
		}
	    }
	}
        if ((PHPKKM_STORAGE=='SQLITE') || (PHPKKM_STORAGE=='MYSQL')) {
    	    //Забираем задания из БД
	    try {
    		$oResults = cModel::$oPDO->query("SELECT tname,tbody FROM ".PHPKKM_SQL_TABLE." WHERE tflag=1");
		foreach ($oResults->fetchAll() as $aRow) {
    		    $aTaskArray[$aRow[tname]]=$aRow[tbody];
    		}
	    } catch(PDOException $e) {
		cLogger::fWriteLog("Невозможно загрузить из БД: ".$e->getMessage(), __FUNCTION__, PHPKKM_LOG_CRIT);
	    }
	}

	echo json_encode(array("result"=>true, "tasks"=>$aTaskArray),JSON_UNESCAPED_UNICODE);
    }

    /**
     * Очистить задания
     *
     * @return json
     */
    public function fClearTasks($aTasksData) {

	foreach($aTasksData as $vTaskName) {
	    //Очищаем переменные
    	    $vTasksName = cSanitizer::fSanitize($vTaskName, 50, "_");
	    // Включена опция архива
	    if (PHPKKM_ARCHIVE) {
		$this->fPutTaskToArchive($vTaskName);
	    } else {
		if (PHPKKM_STORAGE=='DIR') {
		    if (is_file(PHPKKM_TASKS_DIR."/".$vTaskName)) {
			// Удаляем задание
			if (!unlink(PHPKKM_TASKS_DIR."/".$vTaskName)) {
			    cLogger::fWriteLog("Невозможно удалить файл: ".PHPKKM_TASKS_DIR."/".$vTaskName, "", PHPKKM_LOG_WARN);
			} else {
			    cLogger::fWriteLog("Задание удалено.", $vTaskName, "");
			}
    		    }
		}
    		if ((PHPKKM_STORAGE=='SQLITE') || (PHPKKM_STORAGE=='MYSQL')) {
    		    //Удаляем задание из БД
    		    try {
    			$oResults = cModel::$oPDO->query("DELETE FROM ".PHPKKM_SQL_TABLE." WHERE tname='".$vTaskName."'");
			cLogger::fWriteLog("заданию присвоен статус: выполнено", $vTaskName, "");
		    } catch(PDOException $e) {
			cLogger::fWriteLog("Невозможно обновить БД: ".$e->getMessage(), $vTaskName, PHPKKM_LOG_CRIT);
		    }    
    		}
	    }
	}
	echo json_encode(array("result"=>true), JSON_UNESCAPED_UNICODE);
    }

    /**
     * Помещаем задания в архив
     */
    public function fPutTaskToArchive($vTaskName) {

	if (PHPKKM_STORAGE=='DIR') {
	    $vYear = substr($vTaskName, 0,4);
	    // Если нет директории с текущим годом, создаем ее
	    if (!file_exists(PHPKKM_TASKS_ARCHIVE."/".$vYear)) {
		mkdir(PHPKKM_TASKS_ARCHIVE."/".$vYear, 0755, true);
	    }
	    $vMonth = substr($vTaskName, 4,2);
	    // Если нет директории с текущим месяцем, создаем ее
	    if (!file_exists(PHPKKM_TASKS_ARCHIVE."/".$vYear."/".$vMonth)) {
		mkdir(PHPKKM_TASKS_ARCHIVE."/".$vYear."/".$vMonth, 0755, true);
	    }
	    if (is_file(PHPKKM_TASKS_DIR."/".$vTaskName)) {
		// Архивируем задание в директорию TASKS_ARCHIVE / год / месяц
		if (!rename(PHPKKM_TASKS_DIR."/".$vTaskName, PHPKKM_TASKS_ARCHIVE."/".$vYear."/".$vMonth."/".$vTaskName)) {
		    cLogger::fWriteLog("Невозможно переместить файл: ".PHPKKM_TASKS_DIR."/".$vTaskName." в папку: ".PHPKKM_TASKS_ARCHIVE."/".$vYear."/".$vMonth."/".$vTaskName, "", PHPKKM_LOG_WARN);
		} else {
		    cLogger::fWriteLog("Задание перенесено в архив.", $vTaskName, "");
		}
	    }
	}
        if ((PHPKKM_STORAGE=='SQLITE') || (PHPKKM_STORAGE=='MYSQL')) {
    	    //Обновляем статус задания в БД
	    try {
    		$oResults = cModel::$oPDO->query("UPDATE ".PHPKKM_SQL_TABLE." SET tflag=-1 WHERE tname='".$vTaskName."'");
		cLogger::fWriteLog("заданию присвоен статус: архив", $vTaskName, "");
	    } catch(PDOException $e) {
		cLogger::fWriteLog("Невозможно обновить БД: ".$e->getMessage(), $vTaskName, PHPKKM_LOG_CRIT);
	    }    
    	}
    }

    /**
     * Помечаем неисполненные задания
     *
     * @return json
     */
    public function fIncompleteTasks($jData) {

	foreach($jData as $vTaskName=>$jTaskData) {

	    if (PHPKKM_STORAGE=='DIR') {
		file_put_contents(PHPKKM_TASKS_DIR_INCOMPLETE."/".$vTaskName, $jTaskData);
		cLogger::fWriteLog("заданию присвоен статус: не выполнено", $vTaskName, "");
	    }

    	    if ((PHPKKM_STORAGE=='SQLITE') || (PHPKKM_STORAGE=='MYSQL')) {
		// Обновляем статус задания в БД
		try {
		    cModel::$oPDO->query("UPDATE ".PHPKKM_SQL_TABLE." SET tflag=3, tresult='".$jTaskData."' WHERE tname='".$vTaskName."'");
		    cLogger::fWriteLog("заданию присвоен статус: не выполнено", $vTaskName, "");
		} catch(PDOException $e) {
		    cLogger::fWriteLog("Невозможно обновить БД: ".$e->getMessage(), $vTaskName, PHPKKM_LOG_CRIT);
		}
    	    }

	}
	echo json_encode(array("result"=>true),JSON_UNESCAPED_UNICODE);
    }
}

?>