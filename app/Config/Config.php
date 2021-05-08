<?php

ini_set("display_errors", 1);
ini_set("error_reporting", E_ALL & ~E_NOTICE & ~E_DEPRECATED);
//ini_set("error_reporting", 1);

// Корневая папка программы
define ('PHPKKM_ROOT', '/var/www/kassa_tasks');

// URL скрипта
define ('PHPKKM_ROOT_HTTP', 'https://127.0.0.1/kassa_tasks');
// Логин
define('PHPKKM_LOGIN', 'kassa');
// Пароль
define('PHPKKM_PASSWD', '123123');

//Какой обработчик заданий использовать: ATOL, KKMS
define('PHPKKM_ENGINE', 'ATOL');
//define('PHPKKM_ENGINE', 'KKMS');

// Вариант хранения заданий 'DIR' - хранить в директории, SQLITE - хранить в файле базы данных
define('PHPKKM_STORAGE', 'DIR');
//define('PHPKKM_STORAGE', 'SQLITE');
//define('PHPKKM_STORAGE', 'MYSQL');

//-----------------------------------------------------------------------------
// Указывается если для хранения заданий используется SQLITE

// Путь до базы данных SQLITE
define('PHPKKM_SQLITE_PATH', PHPKKM_ROOT.'/db/SQLITE/tasks.db');

//-----------------------------------------------------------------------------
// Указывается если для хранения заданий используется MYSQL

// Хост БД (MYSQL)
define('PHPKKM_PDO_HOSTNAME', '127.0.0.1:3306');
// Название БД (MYSQL)
define('PHPKKM_PDO_DBNAME', 'kassa');
// Название таблицы (MYSQL)
define('PHPKKM_PDO_TABLENAME', 'kassa_tasks');
// Логин БД (MYSQL)
define('PHPKKM_PDO_LOGIN', 'kassa');
// Пароль БД (MYSQL)
define('PHPKKM_PDO_PASSWD', '123123');

//-----------------------------------------------------------------------------
// Указывается если для хранения заданий используются директории

// Директория с заданиями
define('PHPKKM_TASKS_DIR', PHPKKM_ROOT.'/db/Tasks');
// Директория с архивом заданий
define('PHPKKM_TASKS_ARCHIVE', PHPKKM_ROOT.'/db/TasksArchive');
// Директория с архивом заданий
define('PHPKKM_TASKS_DIR_INCOMPLETE', PHPKKM_ROOT.'/db/TasksIncomplete');
// Помещать задания в архив true/false
define('PHPKKM_ARCHIVE', true);
//-----------------------------------------------------------------------------

// Логгирование true/false
define('PHPKKM_LOGGER', true);

// Файл логов
define('PHPKKM_LOG_PATH', PHPKKM_ROOT.'/tmp/log.txt');

define('PHPKKM_LOG_CRIT', 'CRIT');
define('PHPKKM_LOG_WARN', 'WARN');
define('PHPKKM_LOG_SUCC', 'SUCC');


?>