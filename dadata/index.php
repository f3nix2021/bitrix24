<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

/**
 * @var CMain $APPLICATION
 */
$APPLICATION->setTitle('Узнать по инн');

// Dadata 
$token = "c345f20a861190f4500150acad72c185f6a43875"; // ваш api ключ
$secret = "9be2944c996e37149e1e258cfd4f392dc21d0d47"; // ваш секретный ключ

$dadata = new Dadata($token, $secret);
$dadata->init();

// Найти компанию по ИНН
$fields = array("query" => "650501371501", "count" => 5);
$result = $dadata->suggest("party", $fields);
pr($result);



require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/footer.php';





