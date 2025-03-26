<?php
require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/header.php';
/**
 * @var CMain $APPLICATION
 */
$APPLICATION->setTitle('Deal New Api');

use Bitrix\Main\Loader;
use Bitrix\Crm\Service\Container;
if (!Loader::includeModule('crm')) {
    return;
}
$dealOrder = [
    'TITLE' => 'ASC',
];
$dealFilterFields = [];
$dealSelectFields = [
    'ID',
    'TITLE'
];
$dealFactory =
    Container::getInstance()->getFactory(\CCrmOwnerType::Deal);
$dealItems = $dealFactory->getItems([
    'filter' => $dealFilterFields,
    'order' => $dealOrder,
    'select' => $dealSelectFields
]);
foreach ($dealItems as $dealItem) {
    //$dealItem->set('TITLE', '1');
    //pr($dealItem->getData());
    //pr($dealItem->getTitle());
    pr($dealItem->get('TITLE'));
}

require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/footer.php';