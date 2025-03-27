<?php
require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/header.php';

/**
 * @var CMain $APPLICATION
 */

$APPLICATION->setTitle('Magicolors');

// проверим установлен ли модуль "Информационные блоки" и если да то подключим его
if (CModule::IncludeModule("iblock")) {
    CModule::IncludeModule("iblock");
} else echo "module net";

$res = CIBlock::GetList(
    array(),
    array(
        'SITE_ID' => SITE_ID,
        'ACTIVE' => 'Y'
    )
);
echo "<b>Выбор инфоблока:</b></br>";
echo "<form action=\"block.php\" method=\"post\">";
echo "<select name='block'>";
while ($ar_res = $res->Fetch()) {
    if($_POST['block'] == $ar_res['ID']) $sel = "selected"; else $sel = "";
    echo "<option ".$sel." value='".$ar_res['ID']."'>".$ar_res['NAME']."</option>";
}
echo "</select>&nbsp;<input type='submit' value='Экспорт в CSV' />";

echo "</form><br/>";

if(!empty($_POST['block'])) {
    // Открываем файл для записи
    $fileName = "export.csv";
    $file = fopen($fileName, 'w');

    echo "<a target='_blank' href='".$fileName."'>Скачать файл</a><br><br>";
    //echo $_POST['block'];
    // Указываем ID инфоблока
    $iblockId = $_POST['block']; // Замените 1 на ID вашего инфоблока

    // Задаем параметры для выборки
    //$arSelect = ["ID", "NAME", "PREVIEW_TEXT", "DETAIL_PAGE_URL"];
    $arFilter = ["IBLOCK_ID" => $iblockId, "ACTIVE" => "Y"];

    // Получаем элементы 1234

    echo "<table>";
    echo "<th>Name</th>";
    echo "<th>Number</th>";
    echo "<th>File</th>";
    echo "<th>Attachments</th>";
    echo "<th>Description</th>";
    echo "<th>IsExpired</th>";
    echo "<th>Category</th>";
    echo "<th>Tags</th>";
    echo "<th>DateCreated</th>";
    echo "<th>DateUpdated</th>";
    echo "<th>Hypertext</th>";
    echo "<th>Graphic</th>";
    echo "<th>DateEDS</th>";
    echo "<th>FioEDS</th>";
    echo "<th>PositionEDS</th>";
    echo "<th>EDS</th>";

    // Записываем заголовки в CSV
    fputcsv($file, ["Name", "Number", "File", "Attachments", "Description", "IsExpired", "Category",
        "Tags", "DateCreated", "DateUpdated", "Hypertext", "Graphic", "DateEDS",
        "FioEDS", "PositionEDS", "EDS"], ';');

    $res = CIBlockElement::GetList(["SORT" => "ASC"], $arFilter);

    while ($ob = $res->GetNextElement()) {
        $arFields = $ob->GetFields();

        fputcsv($file, [$arFields["NAME"], $arFields["ID"], '', '', $arFields["PREVIEW_TEXT"],
            '', '', '', $arFields["DATE_CREATE"], $arFields["TIMESTAMP_X"], '', '', '', '',
            '', ''], ';');

        echo "<tr>";
            echo "<td>" . $arFields["NAME"] . "</td>"; // название ДА
            echo "<td>" . $arFields["ID"] . "</td>"; // номер документа НЕТ
            echo "<td></td>"; // файл ДА
            echo "<td></td>"; // приложение к документу НЕТ
            echo "<td>".$arFields["PREVIEW_TEXT"]."</td>"; // описание НЕТ
            echo "<td></td>"; // утративший силу истина или ложь ДА
            echo "<td></td>"; // категория документа список НЕТ
            echo "<td></td>"; // тэги список НЕТ
            echo "<td>".$arFields["DATE_CREATE"]."</td>"; // дата опубликования документа дата и время ДА
            echo "<td>".$arFields["TIMESTAMP_X"]."</td>"; // дата изменения документа дата и время НЕТ
            echo "<td></td>"; // гипертекстовый формат файл НЕТ
            echo "<td></td>"; // графический формат файл НЕТ
            echo "<td></td>"; // дата подписания документа дата и время НЕТ
            echo "<td></td>"; // ФИО подписавшего документ строка НЕТ
            echo "<td></td>"; // Должность лица подписавшего документ строка НЕТ
            echo "<td></td>"; // ЭП текстовый блок НЕТ
        echo "</tr>";

        //pr($ob);
    }
    // Закрываем файл
    fclose($file);
    echo "</table>";


}

require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/footer.php';