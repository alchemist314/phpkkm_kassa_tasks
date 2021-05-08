<?php

/**
 * Функция fAutoload для автоматического подключения классов
 */
function fAutoload($vClassName) {

    $vPath = PHPKKM_ROOT."/";
    $vPath .= str_replace("\\", "/", substr($vClassName, 6)) . ".php";
    if (file_exists($vPath)) {
        require $vPath;
    }

}

spl_autoload_register("fAutoload");
