<?php
declare(strict_types=1);

require_once $_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/local/components/test/geoIp.test/class.php';

$request = json_decode(file_get_contents('php://input'), true);

$ip = $request['inputIP'];
$highloadblockId = (int)$request['highloadblockId'];

if (!filter_var($ip, FILTER_VALIDATE_IP)) {
    http_response_code(500);
}

$geoIPTestComponent = new GeoIPTestComponent();

echo $geoIPTestComponent->getIPInfo($ip, $highloadblockId);

require_once $_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/epilog_after.php';
