<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Проверка модуля");
?><?$APPLICATION->IncludeComponent(
	"magicolors:gosweb",
	"",
	Array(
		"TEMPLATE_FOR_CODY" => "10"
	)
);?> <br>
 <br>
 <?$APPLICATION->IncludeComponent(
	"magicolors:webgos",
	"",
	Array(
		"TEMPLATE_FOR_DATE" => "Y-m-d"
	)
);?><br><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>