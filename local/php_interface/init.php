<?php
include_once __DIR__ . '/../app/autoload.php';
include_once __DIR__ . '/classes/BXHelper.php';
include_once __DIR__ . '/classes/LKIblock.php';
include_once __DIR__ . '/classes/Dadata.php';

use Bitrix\Main\Application;
use Bitrix\Main\EventManager;

if (file_exists(__DIR__ . '/classes/autoload.php')) {
    require_once __DIR__ . '/classes/autoload.php';
}

if (file_exists(__DIR__ . '/../../vendor/autoload.php')) {
    require_once __DIR__ . '/../../vendor/autoload.php';
}

require_once(Application::getDocumentRoot() . '/local/php_interface/include/rest/events.php');
require_once(Application::getDocumentRoot() . '/local/php_interface/include/rest/OriginalContactsDataTable.php');

require_once(Application::getDocumentRoot() . '/local/php_interface/include/rest/mir.php');

// вывод данных
function pr($var, $type = false) {
    echo '<pre style="font-size:10px; border:1px solid #000; background:#FFF; text-align:left; color:#000;">';
    if ($type)
        var_dump($var);
    else
        print_r($var);
    echo '</pre>';
}
//test git
$eventManager = EventManager::getInstance();

// пользовательский тип для свойства инфоблока
$eventManager->AddEventHandler(
    'iblock',
    'OnIBlockPropertyBuildList',
    [
        'UserTypes\IBLink', // класс обработчик пользовательского типа свойства
        'GetUserTypeDescription'
    ]
);

// пользовательский тип для UF поля
$eventManager->AddEventHandler(
    'main',
    'OnUserTypeBuildList',
    [
        'UserTypes\FormatTelegramLink', // класс обработчик пользовательского типа UF поля
        'GetUserTypeDescription'
    ]
);

$eventManager->AddEventHandler(
    'iblock',
    'OnIBlockPropertyBuildList',
    [
        'UserTypes\IBRec', // класс обработчик пользовательского типа свойства
        'GetUserTypeDescription'
    ]
);

// обработчик событий инфоблока
$eventManager->addEventHandler("iblock", "OnBeforeIBlockElementAdd", ['Events\IblockHandler', 'onElementBeforeAdd']);
$eventManager->addEventHandler("iblock", "OnAfterIBlockElementUpdate", ['Events\IblockHandler', 'onElementAfterUpdate']);
$eventManager->addEventHandler("iblock", "OnBeforeIBlockElementDelete", ['Events\IblockHandler', 'onElementBeforeDelete']);

// обработчик мой событий по дз
$eventManager->addEventHandler("iblock", "OnBeforeIBlockElementAdd", ['Events\DzRomeo', 'onElementBeforeAdd']);
$eventManager->addEventHandler("iblock", "OnAfterIBlockElementUpdate", ['Events\DzRomeo', 'onElementAfterUpdate']);
$eventManager->addEventHandler("iblock", "OnBeforeIBlockElementDelete", ['Events\DzRomeo', 'onElementBeforeDelete']);


// обработчик событий CRM
$eventManager->addEventHandler(
     "crm",
     "\Bitrix\Crm\Timeline\Entity\Timeline::OnBeforeAdd",
     ['Events\OrmHandler', 'onTimelineBeforeAdd']
 );

/*$eventManager->addEventHandler(
    "crm",
    "OnAfterCrmDealAdd",
    ['Events\DealCrm', 'OnAfterCrmDealAdd']
);*/

// обработчик событий highload-блоков
$entityName = Events\HlblockHandler::getHlIdByName('BooksList');
$eventManager->addEventHandler('', "{$entityName}onBeforeAdd", ['Events\HlblockHandler', 'OnBeforeHLEAdd']);

$eventManager = EventManager::getInstance();
$eventManager->addEventHandlerCompatible('main', 'OnProlog', ['Events\DuplicateCounter\Handler', 'duplicateCounter']);
$eventManager->addEventHandlerCompatible('main', 'OnEpilog', ['Events\DuplicateCounter\Handler', 'duplicateCounter']);

Bitrix\Main\UI\Extension::load(['popup', 'crm.currency', 'timeman.custom']);




