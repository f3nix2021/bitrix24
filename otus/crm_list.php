<?php
require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/header.php';
/**
 * @var CMain $APPLICATION
 */
$APPLICATION->setTitle('Crm list');

use Bitrix\Main\Loader;
if (!Loader::includeModule('crm')) {
    return;
}
$leadOrder = [
    'TITLE' => 'ASC',
];
$leadFilterFields = [
    'ID' => [1, 2 , 3],
];
$leadGroupBy = false;
$leadNavStartParams = false;
$selectFields = [
    'ID',
    'TITLE' ,
    'UF_CRM_MY_CUSTOM_FIELD'
];
$rawLeadList = \CCrmLead::GetListEx(
    $leadOrder,
    $leadFilterFields,
    $leadGroupBy,
    $leadNavStartParams,
    $selectFields
);
while ($lead = $rawLeadList ->fetch()) {
    pr($lead);
}

require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/footer.php';