<?php
require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/header.php';
/**
 * @var CMain $APPLICATION
 */
$APPLICATION->setTitle('Deal New Api 2');

use Bitrix\Main\Loader;
if (!Loader::includeModule('crm')) {
    return;
}

$deal = new \CCrmDeal();

$a = ['CONTACT_ID' => 8];
$deal->Add($a);

//$newDealId = $deal->Add([
    //'COMPANY_ID' => 1, // Для привязки контакта можно передать любой из ключей ниже. Если передана один, другие не нужны
    //'CONTACT_ID' => 8, // Привязка одного контакта
    //'CONTACT_IDS' => [1, 2, 3], // Привязка нескольких контактов. Первый контакт будет сохранен как основной
    /*'CONTACT_BINDINGS' => [ // Привязка нескольких контактов. Позволяет в явном виде задать основной контакт, сортировку и др
    'CONTACT_ID' => 1,
    'SORT' => 10,
    'ROLE_ID' => 0,
    'IS_PRIMARY' => 'Y',
    ],*/
    /*[
        'CONTACT_ID' => 8,
        'SORT' => 20,
    ],*/
//]);

require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/footer.php';