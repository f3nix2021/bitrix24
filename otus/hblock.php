<?php
require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/header.php';
/**
 * @var CMain $APPLICATION
 */
$APPLICATION->setTitle('Демонстрация Higload Block');

use Bitrix\Highloadblock as HL;
use Bitrix\Main\Loader;

Loader::includeModule('highloadblock');

$dbHL = HL\HighloadBlockTable::getList([
    'filter' => [
        'NAME' => 'PantColor'
    ]
]);

if ($arItem = $dbHL->Fetch()) {
    $hlId = $arItem['ID'];
}

//initialize
$hlBlockId = $hlId;
$objHlblock = HL\HighloadBlockTable::getById($hlBlockId)->fetch(); //определяем объект hl-блока
$entity = HL\HighloadBlockTable::compileEntity($objHlblock); //генерация класса
$strEntityDataClass = $entity->getDataClass();

$colors = $strEntityDataClass::getList([
    'select' => ['*'],
    'order' => ['ID' => 'ASC'],
    'count_total' => true,
]);

$prepareElements = [];

while ($color = $colors->fetch()) {
    //$prepareElements[$color['ID']] = $color;
    pr($color);
}

require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/footer.php';