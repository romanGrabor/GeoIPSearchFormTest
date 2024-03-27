<?php
declare(strict_types=1);

use Bitrix\Main\Localization\Loc;

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

$arComponentDescription = [
    'NAME'        => Loc::getMessage('TEST_GEOIP_COMP_NAME'),
    'DESCRIPTION' => Loc::getMessage('TEST_GEOIP_COMP_DESCRIPTION'),
    'SORT'        => 30,
    'CACHE_PATH'  => 'Y',
    'PATH'        => array(
        'ID' => 'content'
    ),
];
