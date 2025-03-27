<?php
include_once(__DIR__.'/cextrest.php');

CRestExt::installApp();

$member_id = $_REQUEST['member_id'];

function getOrganization($data, $key, $page)
{
    // URL для отправки сообщения
    $url = "https://catalog.api.2gis.com/3.0/items?q=".$data."&type=branch&key=".$key."&fields=items.contact_groups&page_size=10&page=".$page;

    // Инициализация cURL
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPGET, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);

    $curlResponse = curl_exec($ch);

    curl_close($ch);

    // Возвращаем JSON-ответ
    header('Content-Type: application/json');

    return json_decode($curlResponse, true);
}

if(!empty($_POST['crm'])) {
    /*echo "<pre>";
    print_r($_POST);
    echo "</pre>";*/

    $sTitle = htmlspecialchars($_POST["org"]);
    $sAddress = htmlspecialchars($_POST["address"]);
    $sPhone = htmlspecialchars($_POST["phone"]);
    $sSite = htmlspecialchars($_POST["site"]);
    $sEmail = htmlspecialchars($_POST["email"]);

    $arPhone = (!empty($sPhone)) ? array(array('VALUE' => $sPhone, 'VALUE_TYPE' => 'WORK')) : array();
    $arSite = (!empty($sSite)) ? array(array('VALUE' => $sSite, 'VALUE_TYPE' => 'WORK')) : array();
    $arEmail = (!empty($sEmail)) ? array(array('VALUE' => $sEmail, 'VALUE_TYPE' => 'HOME')) : array();

    $member_id_new = $_POST['member_id'];
    CRestExt::setCurrentBitrix24($member_id_new);

    $result = CRestExt::call(
        'crm.company.add',
        [
            'fields' =>[
                "TITLE" => $sTitle,//*Company Name[string]
                "COMPANY_TYPE" => 'CUSTOMER',//Company type[crm_status {CUSTOMER:"Client", SUPPLIER:"Supplier", COMPETITOR:"Competitor", PARTNER:"Partner", OTHER:"Other"}]// CRest::call('crm.status.list',['filter'=>['ENTITY_ID'=>'COMPANY_TYPE']]);
                "PHONE" => $arPhone,//Phone[crm_multifield]
                "EMAIL" => $arEmail,//E-mail[crm_multifield]
                //"LOGO" => '',//Logo[file]
                "ADDRESS" => $sAddress,//Street address[string]
                //"ADDRESS_2" => '',//Address (line 2)[string]
                //"ADDRESS_CITY" => '',//City[string]
                //"ADDRESS_POSTAL_CODE" => '',//Zip[string]
                //"ADDRESS_REGION" => '',//Region[string]
                //"ADDRESS_PROVINCE" => '',//State / Province[string]
                //"ADDRESS_COUNTRY" => '',//Country[string]
                //"ADDRESS_COUNTRY_CODE" => '',//Country Code[string]
                //"ADDRESS_LEGAL" => '',//Legal address[string]
                //"REG_ADDRESS" => '',//Billing Address[string]
                //"REG_ADDRESS_2" => '',//Billing Address (line 2)[string]
                //"REG_ADDRESS_CITY" => '',//Billing City[string]
                //"REG_ADDRESS_POSTAL_CODE" => '',//Billing Zip[string]
                //"REG_ADDRESS_REGION" => '',//Billing Region[string]
                //"REG_ADDRESS_PROVINCE" => '',//Billing State / Province[string]
                //"REG_ADDRESS_COUNTRY" => '',//Billing Country[string]
                //"REG_ADDRESS_COUNTRY_CODE" => '',//Billing Country Code[string]
                //"BANKING_DETAILS" => '',//Payment details[string]
                //"INDUSTRY" => '',//Industry[crm_status {IT:"Information Technology", TELECOM:"Telecommunication", MANUFACTURING:"Manufacturing", BANKING:"Banking Services", CONSULTING:"Consulting", FINANCE:"Finance", GOVERNMENT:"Government", DELIVERY:"Delivery", ENTERTAINMENT:"Entertainment", NOTPROFIT:"Non-profit", OTHER:"Other"}]// CRest::call('crm.status.list',['filter'=>['ENTITY_ID'=>'INDUSTRY']]);
                //"EMPLOYEES" => '',//Employees[crm_status {EMPLOYEES_1:"less than 50", EMPLOYEES_2:"50 to 250", EMPLOYEES_3:"250 to 500", EMPLOYEES_4:"over 500"}]// CRest::call('crm.status.list',['filter'=>['ENTITY_ID'=>'EMPLOYEES']]);
                //"CURRENCY_ID" => '',//Currency[crm_currency]// CRest::call('crm.currency.list');
                //"REVENUE" => '',//Annual revenue[double]
                //"OPENED" => '',//Available to everyone[char]
                //"COMMENTS" => '',//Comment[string]
                //"HAS_PHONE" => '',//Has phone[char]
                //"HAS_EMAIL" => '',//Has email[char]
                //"HAS_IMOL" => '',//Has Open Channel[char]
                //"IS_MY_COMPANY" => '',//My Company[char]
                //"ASSIGNED_BY_ID" => '',//Responsible person[user]
                //"CREATED_BY_ID" => '',//Created by[user]
                //"MODIFY_BY_ID" => '',//Modified by[user]
                //"DATE_CREATE" => '',//Created on[datetime]
                //"DATE_MODIFY" => '',//Modified on[datetime]
                //"CONTACT_ID" => '',//Contact[crm_contact]// CRest::call('crm.contact.list');
                //"LEAD_ID" => '',//Lead[crm_lead]
                //"ORIGINATOR_ID" => '',//External source[string]
                //"ORIGIN_ID" => '',//Item ID in data source[string]
                //"ORIGIN_VERSION" => '',//Original version[string]
                //"UTM_SOURCE" => '',//Ad system[string]
                //"UTM_MEDIUM" => '',//Medium[string]
                //"UTM_CAMPAIGN" => '',//Ad campaign UTM[string]
                //"UTM_CONTENT" => '',//Campaign contents[string]
                //"UTM_TERM" => '',//Campaign search term[string]
                "WEB" => $arSite,//Website[crm_multifield]
                //"IM" => '',//Messenger[crm_multifield]
            ]
        ]
    );

    if(!empty($result['result'])){
        echo "<script>alert('Компания успешно была создана!')</script>";
    } else {
        echo "<script>alert('Не могу создать компанию!')</script>";
    }

    /*if(!empty($result['result'])){
        echo json_encode(['message' => 'Company add']);
    }elseif(!empty($result['error_description'])){
        echo json_encode(['message' => 'Company not added: '.$result['error_description']]);
    }else{
        echo json_encode(['message' => 'Company not added']);
    }*/
}
?>
<!doctype html>
<html lang="en" data-bs-theme="auto">
<head><script src="../assets/js/color-modes.js"></script>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.122.0">
    <title>Parser E-mail</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/5.3/examples/checkout/">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@docsearch/css@3">

    <link href="../assets/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }

        .b-example-divider {
            width: 100%;
            height: 3rem;
            background-color: rgba(0, 0, 0, .1);
            border: solid rgba(0, 0, 0, .15);
            border-width: 1px 0;
            box-shadow: inset 0 .5em 1.5em rgba(0, 0, 0, .1), inset 0 .125em .5em rgba(0, 0, 0, .15);
        }

        .b-example-vr {
            flex-shrink: 0;
            width: 1.5rem;
            height: 100vh;
        }

        .bi {
            vertical-align: -.125em;
            fill: currentColor;
        }

        .nav-scroller {
            position: relative;
            z-index: 2;
            height: 2.75rem;
            overflow-y: hidden;
        }

        .nav-scroller .nav {
            display: flex;
            flex-wrap: nowrap;
            padding-bottom: 1rem;
            margin-top: -1px;
            overflow-x: auto;
            text-align: center;
            white-space: nowrap;
            -webkit-overflow-scrolling: touch;
        }

        .btn-bd-primary {
            --bd-violet-bg: #712cf9;
            --bd-violet-rgb: 112.520718, 44.062154, 249.437846;

            --bs-btn-font-weight: 600;
            --bs-btn-color: var(--bs-white);
            --bs-btn-bg: var(--bd-violet-bg);
            --bs-btn-border-color: var(--bd-violet-bg);
            --bs-btn-hover-color: var(--bs-white);
            --bs-btn-hover-bg: #6528e0;
            --bs-btn-hover-border-color: #6528e0;
            --bs-btn-focus-shadow-rgb: var(--bd-violet-rgb);
            --bs-btn-active-color: var(--bs-btn-hover-color);
            --bs-btn-active-bg: #5a23c8;
            --bs-btn-active-border-color: #5a23c8;
        }

        .bd-mode-toggle {
            z-index: 1500;
        }

        .bd-mode-toggle .dropdown-menu .active .bi {
            display: block !important;
        }
    </style>

    <script>
        const input = document.getElementById('numberInput');

        input.addEventListener('input', function() {
            // Удаляем все символы, которые не являются цифрами
            this.value = this.value.replace(/[^0-9]/g, '');
        });
    </script>

    <!-- Custom styles for this template -->
    <link href="../checkout.css" rel="stylesheet">
</head>
<body class="bg-body-tertiary">
<div class="container">
    <main>
        <div class="row g-5">
            <h2 style="text-align: center;"><br/>Поиск организаций в 2ГИС</h2>
            <form class="needs-validation" method="post">
                <b>API ключ от 2ГИС:</b><input class="form-control" placeholder="eb131414141sffsfsgsgsgq24242424" value="<?=$_POST['api']?>" size="46" type="text" name="api" required/><br/>
                <b>Ключевое слово:</b><input class="form-control" placeholder="москва кафе" value="<?=$_POST['search']?>" size="46" type="text" name="search" required/><br/>
                <b>Номер страницы:</b><input id="numberInput" class="form-control" placeholder="1" value="<?=$_POST['page']?>" size="46" type="number" name="page" required/><br/>
                <input class="btn btn-bd-primary py-2 dropdown-toggle d-flex align-items-center" type="submit" value="Найти" />
                <input type="hidden" name="member_id" value="<?=$member_id?>">
            </form>
        </div>
        <div class="row g-5">
            <div style='margin-top: 75px'>
                <table class="table table-hover">
                    <thead>
                        <tr class="table-primary">
                            <th scope="col">#</th>
                            <th scope="col">Название компании</th>
                            <th scope="col">Адрес</th>
                            <th scope="col">Телефон</th>
                            <th scope="col">Сайт</th>
                            <th scope="col">Электронная почта</th>
                            <th scope="col">Действие</th>
                        </tr>
                    </thead>
                    <tbody>

            <?php

                if(!empty($_POST['search']) and !empty($_POST['page']) and !empty($_POST['api']) ) {

                    $searchString = htmlspecialchars($_POST['search'], ENT_QUOTES, 'UTF-8');
                    $page_id = $_POST['page'];
                    $member_id = $_POST['member_id'];
                    $key = $_POST['api'];

                    $searchString = str_replace(" ", "%20", $searchString);

                    //echo "Ты набрал ключевое слово: ".$searchString."<br/>";
                    //echo "Запомнить member_id: ".$member_id."<br/>";


                    $new_data_org = getOrganization($searchString, $key, $page_id);

                    //echo $new_data_org;

                    /*echo "<pre>";
                    print_r($new_data_org);
                    echo "</pre>";*/

                    if(empty($new_data_org['meta']['error']['message'])) {
                        $i = 0;
                        foreach ($new_data_org['result']['items'] as $item) {
                            $i++;
                            echo '<tr>';
                                echo '<th scope="row">'.$i.'</th>';
                                echo '<td>'.$item['name'].'</td>';
                                echo '<td>'.$item['full_name'].'</td>';
                                if($item['contact_groups'][0]['contacts'][0]['type'] == 'phone') $phone = $item['contact_groups'][0]['contacts'][0]['value']; else $phone = "";
                                echo '<td>'.$phone.'</td>';
                                echo '<td>'.$item['contact_groups'][0]['contacts'][0]['url'].'</td>';
                                if($item['contact_groups'][0]['contacts'][4]['type'] == 'email') $email = $item['contact_groups'][0]['contacts'][4]['value']; else $email = "";
                                echo '<td>'.$email.'</td>';

                                echo '<form method="post">';
                                    echo '<input type="hidden" name="org" value="'.$item['name'].'">';
                                    echo '<input type="hidden" name="address" value="'.$item['full_name'].'">';
                                    echo '<input type="hidden" name="phone" value="'.$phone.'">';
                                    echo '<input type="hidden" name="site" value="'.$item['contact_groups'][0]['contacts'][0]['url'].'">';
                                    echo '<input type="hidden" name="email" value="'.$email.'">';
                                    echo '<input type="hidden" name="api" value="'.$key.'">';
                                    echo '<input type="hidden" name="search" value="'.$searchString.'">';
                                    echo '<input type="hidden" name="page" value="'.$page_id.'">';
                                    echo '<input type="hidden" name="member_id" value="'.$member_id.'">';
                                    echo '<td><input class="btn btn-bd-primary py-2 dropdown-toggle d-flex align-items-center" type="submit" name="crm" value="В CRM" /></td>';
                                echo '</form>';
                            echo '</tr>';
                        }
                    } else echo "<tr><td colspan='7' style='text-align: center;'>Ошибка: ".$new_data_org['meta']['error']['message']."</td></tr>";

                }

            ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</div>
</body>
</html>