<?php
require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/header.php';
/**
 * @var CMain $APPLICATION
 */
$APPLICATION->setTitle('Демонстрация Higload Block (добавление)');

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

$ID = 2;
$obResult = $strEntityDataClass::delete($ID);

$bSuccess = $obResult->isSuccess();
if ($bSuccess)
    echo "HL element {$ID} was delete!";
else {
    $arErrors = $obResult->getErrorMessages();
    foreach ($arErrors as $error) {
        echo "ERROR: " . $error . "<br>";
    }
}

require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/footer.php';