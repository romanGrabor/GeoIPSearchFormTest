<?php
/**
 * @var array $arResult
 * @var array $arParams
 * @var string $componentPath
 * @var string $templateFolder
 */

declare(strict_types=1);

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

use Bitrix\Main\Localization\Loc;

?>

<div id="geo-ip-block">
    <div class="geo-ip-form">
        <div class="mb-3">
            <label for="inputIP" class="form-label"><?= Loc::getMessage('TEST_GEOIP_TEST_INPUT_IP_TITLE') ?></label>
            <input type="text" class="form-control" id="inputIP" v-model="inputIP">
            <input type="hidden" value="<?= $templateFolder ?>" id="templateFolder">
            <input type="hidden" value="<?= $arParams['HIGHLOAD_BLOCK_GEO_IP_ID'] ?>" id="highloadblockId">
            <div class="form-text"><?= Loc::getMessage('TEST_GEOIP_TEST_HELP') ?></div>
        </div>
        <button type="submit" class="btn btn-primary"
                @click="searchInfo()"><?= Loc::getMessage('TEST_GEOIP_TEST_BUTTON_TITLE') ?></button>
    </div>

    <div class="row" v-if="seen">
        <h2>Результат</h2>

        <div class="col-6 col-sm-3">IP</div>
        <div class="col-6 col-sm-3">{{ IP }}</div>
        <div class="w-100"></div>
        <div class="col-6 col-sm-3"><?= Loc::getMessage('TEST_GEOIP_TEST_COORDINATES_TITLE') ?></div>
        <div class="col-6 col-sm-3">{{ coordinates }}</div>
        <div class="w-100"></div>
        <div class="col-6 col-sm-3"><?= Loc::getMessage('TEST_GEOIP_TEST_CITY_TITLE') ?></div>
        <div class="col-6 col-sm-3">{{ city }}</div>
        <div class="w-100"></div>
        <div class="col-6 col-sm-3"><?= Loc::getMessage('TEST_GEOIP_TEST_REGION_TITLE') ?></div>
        <div class="col-6 col-sm-3">{{ region }}</div>
        <div class="w-100"></div>
        <div class="col-6 col-sm-3"><?= Loc::getMessage('TEST_GEOIP_TEST_COUNTRY_TITLE') ?></div>
        <div class="col-6 col-sm-3">{{ country }}</div>
    </div>
</div>
