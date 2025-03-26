<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Новый модуль");
?><?$APPLICATION->IncludeComponent(
	"otus:vacation.schedule",
	"",
	Array(
		"DATETIME_FORMAT" => "d.m.Y H:i:s",
		"DATE_FORMAT" => "d.m.Y",
		"DAY_FINISH" => "18",
		"DAY_SHOW_NONWORK" => "N",
		"DAY_START" => "9",
		"FILTER_CONTROLS" => array("DATEPICKER","TYPEFILTER","DEPARTMENT"),
		"FIRST_DAY" => "1",
		"NAME_TEMPLATE" => "#NOBR##LAST_NAME# #NAME##/NOBR#",
		"VIEW_START" => "month"
	)
);?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>