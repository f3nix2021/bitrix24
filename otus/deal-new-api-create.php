<?php
require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/header.php';
/**
 * @var CMain $APPLICATION
 */
$APPLICATION->setTitle('Deal New Api CREATE');

use Bitrix\Main\Loader;
use Bitrix\Crm\Service\Container;
if (!Loader::includeModule('crm')) {
    return;
}
$dealFields = [
    'TITLE' => 'Тестовая сделка222 D7',
    'STAGE_ID' => 'NEW'
];
$newDealModel = new \CCrmDeal();
$newDealModel->Add($dealFields);

//pr($dealFields);
echo "create crm deal: ".$dealFields['ID'];

/*use Bitrix\Main\Loader;
use Bitrix\Crm\Service\Container;
if (!Loader::includeModule('crm')) {
    return;
}
$dealFactory = Container::getInstance()->getFactory(\CCrmOwnerType::Deal);
$newDealItem = $dealFactory->createItem();
$newDealItem->set('TITLE', 'Тестовая сделка D7 - ' . date('d-m-Y H-i-s'));
//$newDealItem->save(); //Выполнит сохранение сразу без проверки
//прав доступа и без запуска обработчиков событий

$dealAddOperation = $dealFactory->getAddOperation($newDealItem);

pr($dealAddOperation);

$addResult = $dealAddOperation->launch();*/



require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/footer.php';