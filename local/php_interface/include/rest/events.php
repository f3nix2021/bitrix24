<?php
namespace Otus\Rest;

use Bitrix\Main\EventManager;
use Bitrix\Rest\RestException;
use Bitrix\Main\Event;
use Bitrix\Main\Engine\CurrentUser;

use Bitrix\Main\Localization\Loc;
Loc::loadMessages(__FILE__);

$eventManager = EventManager::getInstance();
$eventManager->addEventHandlerCompatible('rest', 'OnRestServiceBuildDescription', ['Otus\Rest\Events', 'OnRestServiceBuildDescriptionHandler']);


class Events
{
    /**
     * Register rest methods
     * Clear scope cache after register
     * Bitrix\Main\Data\Cache::clearCache(true, '/rest/scope/');
     * @return array[]
     */
    public static function OnRestServiceBuildDescriptionHandler()
    {
        Loc::getMessage('REST_SCOPE_OTUS.ORIGINALCONTACTSDATA');

        return [
            'otus.originalcontactsdata' => [
                'otus.originalcontactsdata.add' => [__CLASS__, 'add'],
                'otus.originalcontactsdata.list' => [__CLASS__, 'list'],
                \CRestUtil::EVENTS => [
                    'onAfterOOCDAdd' => [
                        'main',
                        'onAfterOtusOriginalContactsDataAdd',
                        [__CLASS__, 'prepareEventData']
                    ]
                ]
            ]
        ];
    }
    public static function list($arParams, $navStart, \CRestServer $server)
    {
        if (!empty($arParams))
        {
            $arFilter = isset($arParams['filter']) ? $arParams['filter'] : [];
            foreach ($arFilter as &$filter)
            {
                $filter = htmlspecialchars($filter);
                $filter = trim($filter);
            }
        }
        else
        {
            return [Loc::getMessage('')];
        }


        try
        {
            $result = OriginalContactsDataTable::getList([
                'filter' => $arFilter,
                'select' => $arParams['select'],
//                'order' => $arParams['order'],
//                'limit' => $arParams['limit'],
//                'offset' => $navStart, dfdgdg
            ])->fetchAll();
        }
        catch (\Exception $e)
        {
            throw new RestException(json_encode($e->getMessage(), JSON_UNESCAPED_UNICODE), RestException::ERROR_ARGUMENT, \CRestServer::STATUS_OK);
        }

        return $result;
    }


    /**
     * @param array $arParams
     * @param int $navStart
     * @param \CRestServer $server
     * @return mixed
     * @throws RestException
     */
    public static function add (array $arParams, int $navStart, \CRestServer $server)
    {

//        file_put_contents($_SERVER['DOCUMENT_ROOT'].'/logRest.txt', 'PARAMS: '.var_export($arParams, true).PHP_EOL, FILE_APPEND);
//        file_put_contents($_SERVER['DOCUMENT_ROOT'].'/logRest.txt', 'NAV: '.var_export($navStart, true).PHP_EOL, FILE_APPEND);
//        file_put_contents($_SERVER['DOCUMENT_ROOT'].'/logRest.txt', 'SERVER: '.var_export($server, true).PHP_EOL, FILE_APPEND);
//        file_put_contents($_SERVER['DOCUMENT_ROOT'].'/logRest.txt', 'REQUEST_METHOD: '.var_export($_SERVER['REQUEST_METHOD'], true).PHP_EOL, FILE_APPEND);

        $originDataStoreResult = OriginalContactsDataTable::add($arParams);
        if ($originDataStoreResult->isSuccess())
        {
            $id = $originDataStoreResult->getId();
            $arParams['ID'] = $id;
            $event = new Event('main', 'onAfterOtusOriginalContactsDataAdd', $arParams);
            $event->send();

            return $id;
        }
        else
        {
            throw new RestException(json_encode($originDataStoreResult->getErrorMessages(), JSON_UNESCAPED_UNICODE), RestException::ERROR_ARGUMENT, \CRestServer::STATUS_OK);
        }
    }

    /**
     * Prepare data
     * @param $arguments - data
     * @param $handler - handler
     * @return mixed
     */
    public static function prepareEventData($arguments, $handler)
    {
//        file_put_contents($_SERVER['DOCUMENT_ROOT'].'/logRestEvent.txt', 'A: '.var_export($arguments, true).PHP_EOL, FILE_APPEND);
//        file_put_contents($_SERVER['DOCUMENT_ROOT'].'/logRestEvent.txt', 'H: '.var_export($handler, true).PHP_EOL, FILE_APPEND);
        /** @var Event $event */
        $event = reset($arguments);
        $response = $event->getParameters();
//        file_put_contents($_SERVER['DOCUMENT_ROOT'].'/logRestEvent.txt', 'R: '.var_export($response, true).PHP_EOL, FILE_APPEND);

        return $response;
    }
}