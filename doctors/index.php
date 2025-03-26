<?php
require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/header.php';

/**
 * @var CMain $APPLICATION
 */

$APPLICATION->setTitle('Доктор MOM');

use Bitrix\Main\Loader;
use Bitrix\Iblock\Iblock;
Loader::includeModule('iblock');

if($_POST['add_procedure'] and !empty($_POST['name_procedure'])) {

    $iblockId = 20;

    $arIblockFields = [
        'IBLOCK_ID' => $iblockId,
        'NAME' => $_POST['name_procedure']
    ];
    $objIblockElement = new \CIBlockElement();
    $objIblockElement->Add($arIblockFields);
}

if($_POST['add_doctors'] and !empty($_POST['name_page'])) {

    $iblockId = 19;

    $arElementProps = [
        'LAST' => $_POST['lname'],
        'FIRST' => $_POST['fname'],
        'SURNAME' => $_POST['surname'],
        'PROCEDURES' => $_POST['proc']
    ];

    $arIblockFields = [
        'IBLOCK_ID' => $iblockId,
        'NAME' => $_POST['name_page'],
        'PROPERTY_VALUES' => $arElementProps
    ];
    $objIblockElement = new \CIBlockElement();
    $objIblockElement->Add($arIblockFields);
}

echo "<h1 style='text-align: center; color: #3F729C'>Врачи</h1>";

if($_POST['doctor']) { // ДОБАВЛЕНИЕ ВРАЧА
    $elements = \Bitrix\Iblock\Elements\ElementProceduresTable::getList([
        'select' => ['ID', 'NAME'], // имя свойства
    ])->fetchCollection();

    echo "<h2 style='text-align: center; color: #666666'>Данные врача</h2>";
    echo "<form method='POST'>";

    echo "<div style='text-align: center; margin: 5px'><input type='text' name='name_page' placeholder='Название страницы врача (фамилия латиницей)' size='45' /></div>";
    echo "<div style='text-align: center; margin: 5px'><input type='text' name='lname' placeholder='Фамилия врача' size='45' /></div>";
    echo "<div style='text-align: center; margin: 5px'><input type='text' name='fname' placeholder='Имя врача' size='45' /></div>";
    echo "<div style='text-align: center; margin: 5px'><input type='text' name='surname' placeholder='Отчество врача' size='45' /></div>";
    echo "<div style='text-align: center; margin: 5px'>
            <select size='4' multiple name='proc[]' style='width: 330px'>
            <option disabled>Процедуры</option>";
                foreach ($elements as $element) {
                    echo "<option value='" . $element->get('ID') . "'>" . $element->get('NAME') . "</option>";
                }
    echo "</select></div>";
    echo "<div style='text-align: center; margin: 5px'><input style='width: 330px' type='submit' name='add_doctors' value='Добавить врача' /></div>";
    echo "</form>";

}
elseif ($_POST['procedure']) { // ДОБАВЛЕНИЕ ПРОЦЕДУРЫ
    echo "<h2 style='text-align: center; color: #666666'>Добавить процедуру</h2>";
    echo "<form method='POST'>";

    echo "<div style='text-align: center; margin: 5px'><input type='text' name='name_procedure' placeholder='Название процедуры' size='45' /></div>";
    echo "<div style='text-align: center; margin: 5px'><input style='width: 330px' type='submit' name='add_procedure' value='Добавить процедуру' /></div>";
    echo "</form>";
}
else { // ГЛАВНАЯ СТРАНИЦА

    echo "<form method='POST'>";

    echo "<p><input type='submit' name='doctor' value='Добавить врача'/>&nbsp;<input type='submit' name='procedure' value='Добавить процедуру' /></p>";

    echo "</form>";

    $elements = \Bitrix\Iblock\Elements\ElementDoctorsTable::getList([
        'select' => ['NAME', 'LAST', 'FIRST', 'SURNAME'], // имя свойства
    ])->fetchCollection();

    echo "<div style='padding-left: 40%; margin-top: 5%'>";

    foreach ($elements as $element) {

        $fio_doctors = $element->get('LAST')->getValue() . ' ' . $element->get('FIRST')->getValue() . ' ' . $element->get('SURNAME')->getValue();
        echo '<div style="margin: 5px; border: 1px solid cornflowerblue; text-align: center; vertical-align: center; width: 250px; height: 100px;"><b><a href="doctor.php?id_doctor='.$element->get('ID').'">' . $fio_doctors . '</a></b></div>';

    }

    echo "</div>";

}

require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/footer.php';