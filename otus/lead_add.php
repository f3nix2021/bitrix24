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

$leadFields = [
    'TITLE' => 'TEST-' .
        date('d-m-Y-H-i-s' ),
    'UF_CRM_1732637027' => [
        'TEST',
        'TEST2',
    ],
];
$leadModel = new \CCrmLead ;
$res = $leadModel ->add($leadFields);
var_dump ($res);

require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/footer.php';