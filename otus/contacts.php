<?php
require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/header.php';
/**
 * @var CMain $APPLICATION
 */
$APPLICATION->setTitle('Deal New Api CREATE');

use Bitrix\Main\Loader;
if (!Loader::includeModule('crm')) {
    return;
}

$phone = '+79999999999';

$contactFields = [
    'NAME' => 'Роман',
    'LAST_NAME' => 'Лихач',
];

$contactsModel = new \CCrmContact;

$newContactId = $contactsModel->Add($contactFields);

$cont = [
    [
        'ENTITY_ID' => 'CONTACT', // Тип сущности -контакт
        'ELEMENT_ID' => $newContactId, // ID Контакта
        'TYPE_ID' => 'PHONE',
        'VALUE_TYPE' => 'WORK',
        'VALUE' => $phone // Номер телефона
    ],
    [
        'ENTITY_ID' => 'CONTACT', // Тип сущности -контакт
        'ELEMENT_ID' => $newContactId, // ID Контакта
        'TYPE_ID' => 'PHONE',
        'VALUE_TYPE' => 'WORK',
        'VALUE' => '+79242829162' // Номер телефона
    ],
];

$multi = new CCrmFieldMulti();

foreach ($cont as $item) {
    $multi->Add($item);
}

require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/footer.php';