<?php
declare(strict_types=1);

use Bitrix\Highloadblock\HighloadBlockTable;
use Bitrix\Main\Loader;

/**
 * Class GeoIP.
 */
class GeoIPTestComponent extends CBitrixComponent
{
    private string $highloadblockTable = '';

    /**
     * @return true
     */
    public function executeComponent()
    {
        $this->arParams[''] = 2;
        parent::executeComponent();

        $this->includeComponentTemplate();

        return true;
    }

    /**
     * Возвращаем данные IP-адреса в формате json.
     *
     * @param string $ip
     * @param int    $highloadblockId
     *
     * @return string
     */
    public function getIPInfo(string $ip, int $highloadblockId): string
    {
        $this->setHighloadblockEntityTable($highloadblockId);

        $ipInfo = $this->getIPInfoFromDB($ip);

        if ($ipInfo) {
            return json_encode($ipInfo);
        }

        $ipInfo = $this->getIPInfoFromService($ip);

        if ($ipInfo) {
            $this->addIPInfo($ipInfo);
        }

        return json_encode($ipInfo);
    }

    /**
     * Возвращает данные IP-адреса, полученные в базе данных.
     *
     * @param string $ip
     *
     * @return void
     */
    private function getIPInfoFromDB(string $ip): array
    {
        try {
            $ipInfoData = $this->highloadblockTable::getList(
                [
                    'filter' => ['UF_IP' => $ip]
                ]
            )->fetch();
        } catch (Exception $exception) {
            CEventLog::Add(array(
                'ERROR'         => 'ERROR',
                'AUDIT_TYPE_ID' => 'GEO_IP_TEST_COMPONENT',
                'MODULE_ID'     => 'highloadblock',
                'DESCRIPTION'   => $exception->getMessage(),
            ));
        }

        if (!empty($ipInfoData)) {
            $ipInfo = [
                'ip'          => $ipInfoData['UF_IP'],
                'city'        => $ipInfoData['UF_CITY'],
                'coordinates' => $ipInfoData['UF_COORDINATES'],
                'region'      => $ipInfoData['UF_REGION'],
                'country'     => $ipInfoData['UF_COUNTRY']
            ];
        }

        return (empty($ipInfo)) ? [] : $ipInfo;
    }

    /**
     * Добавляем данные IP-адреса в базу данных.
     *
     * @param array $ipInfo
     *
     * @return bool
     */
    private function addIPInfo(array $ipInfo)
    {
        if (empty($ipInfo) || empty($ipInfo['ip'])) {
            return false;
        }

        try {
            $result = $this->highloadblockTable::add(
                [
                    'UF_IP'          => ($ipInfo['ip']) ?: '',
                    'UF_CITY'        => ($ipInfo['city']) ?: '',
                    'UF_COORDINATES' => ($ipInfo['coordinates']) ?: '',
                    'UF_REGION'      => ($ipInfo['region']) ?: '',
                    'UF_COUNTRY'     => ($ipInfo['country']) ?: '',
                ]
            );
        } catch (Exception $exception) {
            CEventLog::Add(array(
                'ERROR'         => 'ERROR',
                'AUDIT_TYPE_ID' => 'GEO_IP_TEST_COMPONENT',
                'MODULE_ID'     => 'highloadblock',
                'DESCRIPTION'   => $exception->getMessage(),
            ));
        }

        return ($result) ? true : false;
    }

    /**
     * Возвращает данные IP-адреса, полученные от сервиса sypexgeo.
     *
     * @param string $ip
     *
     * @return string
     */
    private function getIPInfoFromService(string $ip): array
    {
        $ipInfo = [];
        $queryUrl = sprintf('https://api.sypexgeo.net/json/%s/', $ip);

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL            => $queryUrl,
            CURLOPT_RETURNTRANSFER => true,
        ]);

        $result = curl_exec($curl);
        curl_close($curl);

        $result = json_decode($result);

        if ($result->{'ip'}) {
            $ipInfo = [
                'ip'          => $result->{'ip'},
                'city'        => $result->{'city'}->{'name_ru'},
                'coordinates' => sprintf('%s, %s', $result->{'city'}->{'lat'}, $result->{'city'}->{'lon'}),
                'region'      => $result->{'region'}->{'name_ru'},
                'country'     => $result->{'country'}->{'name_ru'}
            ];
        }

        return $ipInfo;
    }

    /**
     * Устанавливает таблицу для работы с Highload-блоком.
     *
     * @param int $highloadblockId
     *
     * @return string
     */
    private function setHighloadblockEntityTable(int $highloadblockId): string
    {
        if ($this->highloadblockTable) {
            return $this->highloadblockTable;
        }

        try {
            Loader::includeModule('highloadblock');

            $highloadBlock = HighloadBlockTable::getById($highloadblockId)->fetch();
            $entity = HighloadBlockTable::compileEntity($highloadBlock);

            $this->highloadblockTable = (string)$entity->getDataClass();
        } catch (Exception $exception) {
            CEventLog::Add(array(
                'ERROR'         => 'ERROR',
                'AUDIT_TYPE_ID' => 'GEO_IP_TEST_COMPONENT',
                'MODULE_ID'     => 'highloadblock',
                'DESCRIPTION'   => $exception->getMessage(),
            ));

            unset($exception);
        }

        unset($highloadBlock, $entity);

        return $this->highloadblockTable;
    }
}
