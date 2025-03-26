<?php
require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/header.php';
/**
 * @var CMain $APPLICATION
 */
$APPLICATION->setTitle("Компонент кастомный Валюты");
?><?$APPLICATION->IncludeComponent(
	"magicolors:currency", 
	".default", 
	array(
		"TEMPLATE_FOR_CURRENCY" => "UAH",
		"COMPONENT_TEMPLATE" => ".default"
	),
	false
);?><?php
require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/footer.php';
?>