<?php
require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/header.php';
/**
 * @var CMain $APPLICATION
 */
$APPLICATION->setTitle('Узнать свой ИНН по паспорту');

function suggestInn($surname, $name, $patronymic, $birthdate, $doctype, $docnumber, $docdate)
{
    $url = "https://service.nalog.ru/inn-proc.do";
    $data = array(
        "fam" => $surname,
        "nam" => $name,
        "otch" => $patronymic,
        "bdate" => $birthdate,
        "bplace" => "",
        "doctype" => $doctype,
        "docno" => $docnumber,
        "docdt" => $docdate,
        "c" => "innMy",
        "captcha" => "",
        "captchaToken" => ""
    );
    $options = array(
        'http' => array(
            'method'  => 'POST',
            'header'  => array(
                'Content-type: application/x-www-form-urlencoded',
            ),
            'content' => http_build_query($data)
        ),
    );

    $context = stream_context_create($options);
    $result = file_get_contents($url, false, $context);

    return $result;
}

$resp = suggestInn("Лихач", "Роман", "Валерьевич", "15.11.1985", "21", "64 23 098103", "23.03.2023");
//print_r($resp);
$object = json_decode($resp);
print_r($object);
//echo $object->inn;

require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/footer.php';