<?php
require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/header.php';

/**
 * @var CMain $APPLICATION
 */

$APPLICATION->setTitle('Доктор MOM');

use Bitrix\Main\Loader;
use Bitrix\Iblock\Iblock;
Loader::includeModule('iblock');

$iblockId = 19;
$iblockElementId = $_GET['id_doctor'];

$iblock = Iblock::wakeUp($iblockId);

$element = $iblock->getEntityDataClass()::getByPrimary(
    $iblockElementId,
    ['select' => ['NAME', 'LAST', 'FIRST', 'SURNAME']])
    ->fetchObject();

$fio = $element->get('LAST')->getValue().' '.$element->get('FIRST')->getValue().' '.$element->get('SURNAME')->getValue();

$element = \Bitrix\Iblock\Elements\ElementDoctorsTable::getList([
    'select' => ['ID', 'NAME', 'LAST', 'FIRST', 'SURNAME', 'PROCEDURES'],
    'filter' => [
        'ID' => $iblockElementId,
    ],
])->fetchObject();

$procedures = "";

foreach ($element->getProcedures()->getAll() as $section) {
    //$procedures .= $section->getValue() . '<br>';

    $element = \Bitrix\Iblock\Elements\ElementProceduresTable::getList([
        'select' => ['ID', 'NAME'],
        'filter' => [
            'ID' => $section->getValue(),
        ],
    ])->fetchObject();

    $procedures .= $element->getName() . '<br>';
}

echo "<h2 style='color: #666666'>".$fio."</h2>";
echo "<div><b>Процедуры:</b></div>";
echo "<div>".$procedures."</div><br/>";
echo "<div><a href='/doctors/'>Вернуться на главную</a></div>";

require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/footer.php';