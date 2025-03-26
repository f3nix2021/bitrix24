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
$dealFactory = Container::getInstance()->getFactory(\CCrmOwnerType::Deal);
$existedDealId = 13;
$dealItem = $dealFactory->getItem($existedDealId);

# $dealItem->delete();
# $newDealItem->save(); Выполнит сохранение сразу без
//проверки прав доступа и без запуска обработчиков событий

$dealUpdateOperation = $dealFactory->getDeleteOperation($dealItem);

$deleteResult = $dealUpdateOperation->launch();

require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/footer.php';