<?php
require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/header.php';
/**
 * @var CMain $APPLICATION
 */
$APPLICATION->setTitle('Smart New Api');

use Bitrix\Main\Loader;
use Bitrix\Crm\Service\Container;
if (!Loader::includeModule('crm')) {
    return;
}
$spOrder = [
    'TITLE' => 'ASC',
];
$spFilterFields = [];
$spSelectFields = [
    'ID',
    'TITLE'
];
$spFactory =
    Container::getInstance()->getFactory(1036);
$spItems = $spFactory->getItems([
    'filter' => $spFilterFields,
    'order' => $spOrder,
    'select' => $spSelectFields
]);
foreach ($spItems as $spItem) {
    //$dealItem->set('TITLE', '1');
    //pr($dealItem->getData());
    //pr($dealItem->getTitle());
    pr($spItem->get('TITLE'));
}

pr($spItems[0]->get('ID'));

require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/footer.php';