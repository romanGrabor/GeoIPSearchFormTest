<?php
/**
 * @var \CMain $APPLICATION
 */

declare(strict_types=1);
require_once $_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php'; ?>

    <!DOCTYPE html>
    <html>
    <head>
        <meta charset="UTF-8">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
              integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
              crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
                integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
                crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.5.0/axios.min.js"></script>
        <script src="https://unpkg.com/vue@3.4.6"></script>
        <?php
        $APPLICATION->ShowHead(); ?>
    </head>
    <body>
    <?php
    $APPLICATION->ShowPanel() ?>
    <div class="container">
        <h1>Бесплатный сервис Geo IP</h1>
        <?php
        $APPLICATION->IncludeComponent(
            'test:geoIp.test',
            '',
            [
                'HIGHLOAD_BLOCK_GEO_IP_ID' => 2
            ]
        ); ?>
    </div>
    </body>
    <html>
<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/epilog_after.php';
