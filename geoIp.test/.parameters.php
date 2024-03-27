<?php
declare(strict_types=1);

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

$arComponentParameters = [
    'PARAMETERS' => [
        'HIGHLOAD_BLOCK_GEO_IP_ID' => [
            'PARENT'  => 'BASE',
            'NAME'    => Loc::getMessage('TEST_GEOIP_COMP_HIGHLOAD_BLOCK_GEO_IP_ID'),
            'TYPE'    => 'STRING',
            'DEFAULT' => ''
        ],
    ],
];