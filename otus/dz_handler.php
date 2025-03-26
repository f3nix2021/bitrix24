<?php
file_put_contents($_SERVER['DOCUMENT_ROOT'].'/otus/rest_log_dz_handler.txt', var_export($_REQUEST, true), FILE_APPEND);

class DzHandler
{
    public static function editContact(): void
    {
        $contactFields = [
            'UF_CRM_1739033849' => date('d.m.Y H:i:s'),
        ];

        $response = self::sendNewRequest('/crm.contact.update', [
            'id' => 1,
            'fields' => $contactFields,
        ]);
    }

    private static function sendNewRequest(string $endpoint, array $data): array
    {
        $url = 'https://ce76367.tw1.ru/rest/1/ihp9s00tdbpukbsg/' . $endpoint;
        $query = http_build_query($data);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url . '?' . $query);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/x-www-form-urlencoded',
        ]);

        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $response = curl_exec($ch);

        if ($response === false) {
            $error = curl_error($ch);
            file_put_contents($_SERVER['DOCUMENT_ROOT'] . '/otus/rest_log_dz_handler.log', var_export('ОШИБКА: ' . $error, true), FILE_APPEND);
            curl_close($ch);
        }

        curl_close($ch);

        return json_decode($response, true);
    }
}

DzHandler::editContact();