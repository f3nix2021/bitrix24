<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

/**
 * @var CMain $APPLICATION
 */

$APPLICATION->SetTitle('Отдел кадров');

use Models\PersonTable as Person;

$collection = Person::getList([
    'select' => [
        'id',
        'first_name',
        'job_title_id',
        'year_of_admission',
        'experience_id',
        'departament',
        'surcharge_id',
        'birthday_year',
        'telephone',
        'place_of_birth'
    ],
])->fetchCollection();

foreach ($collection as $key => $record) {
    echo $record->getId().') '.$record->getFirstName().' '.$record->getJobTitleId().' '.$record->getYearOfAdmission().' 
    '.$record->getExperienceId().' '.$record->getDepartament().' '.$record->getSurchargeId().' 
    '.$record->getBirthdayYear().' '.$record->getTelephone().' '.$record->getPlaceOfBirth();

    echo '<br/>';
}

require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/footer.php';