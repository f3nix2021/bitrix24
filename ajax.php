<?php
require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/header.php';
/**
 * @var CMain $APPLICATION
 */
$APPLICATION->setTitle('ajax');

use Bitrix\Main\Loader;
use Bitrix\Iblock\Iblock;
Loader::includeModule('iblock');

/*if($_POST['FIO']) {

    $iblockId = 41;

    $arIblockFields = [
        'IBLOCK_ID' => $iblockId,
        'NAME' => $_POST['FIO'],
        'VREMYA_ZAPISI' => $_POST['TIME_REC'],
        'PROTSEDURA' => $_POST['PROCEDURE']
    ];
    $objIblockElement = new \CIBlockElement();
    $objIblockElement->Add($arIblockFields);

}*/

if($_POST['FIO']) {


    $iblockId = 41;

    $arElementProps = [
        'VREMYA_ZAPISI' => $_POST['TIME_REC'],
        'PROTSEDURA' => $_POST['PROCEDURE']
    ];

    $arIblockFields = [
        'IBLOCK_ID' => $iblockId,
        'NAME' => $_POST['FIO'],
        'PROPERTY_VALUES' => $arElementProps
    ];

    $objIblockElement = new \CIBlockElement();
    $objIblockElement->Add($arIblockFields);

}



require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/footer.php';