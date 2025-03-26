<?php
require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/header.php';
/**
 * @var CMain $APPLICATION
 */
$APPLICATION->setTitle('Cache');

use Bitrix\Main\Data\Cache;
use Bitrix\Main\Application;
use Bitrix\Main\Loader;

$cacheTime = 30*60;
$cacheId = $_REQUEST['CACHE_ID'];
$cacheDir = '/otus/';

/*$cache = Bitrix\Main\Data\Cache::createInstance();
if ($cache->initCache($cacheTime, $cacheId, $cacheDir))
{
    $result = $cache->getVars();
}
elseif ($cache->startDataCache())
{
    $result = array();
    // ...
    if ($isInvalid)
    {
        $cache->abortDataCache();
    }
    // ...
    $cache->endDataCache($result);
}*/

require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/footer.php';