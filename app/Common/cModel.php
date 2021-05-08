<?php

namespace phpKKM\app\Common;

/**
 * Абстрактный класс cModel содержит общую логику для всех моделей
 */

abstract class cModel {
    /**
    * Содержит обьект базы данных PDO
    *
    * @object
    */
    public static $oPDO;
}

?>