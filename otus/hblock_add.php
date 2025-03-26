<?php
require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/header.php';
/**
 * @var CMain $APPLICATION
 */
$APPLICATION->setTitle('Демонстрация Higload Block (добавление)');

use Bitrix\Highloadblock as HL;
use Bitrix\Main\Loader;

Loader::includeModule('highloadblock');

$arElementFields = array(
    'UF_NAME' => '#XD867433424',
    'UF_XML_ID' => '500',
);

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

$obResult = $strEntityDataClass::add($arElementFields);
$ID = $obResult->getID();
$bSuccess = $obResult->isSuccess();
if ($bSuccess)
    echo "HL element {$ID} was added!";
else {
    $arErrors = $obResult->getErrorMessages();
    foreach ($arErrors as $error) {
        echo "ERROR: " . $error . "<br>";
    }
}

require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/footer.php';