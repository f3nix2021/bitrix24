<?php
require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/header.php';
/**
 * @var CMain $APPLICATION
 */
$APPLICATION->setTitle("Компонент кастомный Таблицы");
?><?$APPLICATION->IncludeComponent(
	"otus:table.views",
	"list",
	Array(
		"NUM_PAGE" => "20",
		"SHOW_CHECKBOXES" => "Y"
	)
);?><?php
require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/footer.php';
?>