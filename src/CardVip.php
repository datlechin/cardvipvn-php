<?php

namespace Datlechin\CardVipPHP;

class CardVip
{
    /**
     * @var string $apiUrl
     */
    private string $apiUrl = 'https://api.cardvip.vn/api/';

    /**
     * @var string $apiKey
     */
    private string $apiKey;

    /**
     * @var string $telco
     */
    private string $telco;

    /**
     * @var int $amount
     */
    private int $amount;

    /**
     * @var string $serial
     */
    private string $serial;

    /**
     * @var string $pin
     */
    private string $pin;

    /**
     * @var bool $isFast
     */
    private bool $isFast = true;

    /**
     * @var string $requestId
     */
    private string $requestId;

    /**
     * @var string $callbackUrl
     */
    private string $callbackUrl;

    /**
     * @param string $apiKey
     */
    public function __construct(string $apiKey)
    {
        $this->apiKey = $apiKey;
    }

    /**
     * Đẩy thẻ lên trang web cardvip.vn
     *
     * @param string $telco
     * @param int $amount
     * @param string $serial
     * @param string $pin
     * @param string $requestId
     * @param string $callbackUrl
     * @return string
     */
    public function exchange(string $telco, int $amount, string $serial, string $pin, string $requestId, string $callbackUrl): string
    {
        $this->setExchangeData($telco, $amount, $serial, $pin, $requestId, $callbackUrl);

        return $this->sendRequest('POST', 'createExchange', [
            'APIKey' => $this->apiKey,
            'NumberCard' => $this->pin,
            'SeriCard' => $this->serial,
            'NetworkCode' => $this->telco,
            'PricesExchange' => $this->amount,
            'IsFast' => $this->isFast,
            'RequestId' => $this->requestId,
            'UrlCallback' => $this->callbackUrl,
        ]);
    }

    /**
     * Đổi thẻ có bảo hiểm, mặc định là true
     *
     * @param bool $isFast
     * @return void
     */
    public function isFast(bool $isFast): void
    {
        $this->isFast = $isFast;
    }

    /**
     * @param string $request_id
     * @return bool|string
     */
    public function checkCard(string $request_id): bool|string
    {

        $query = http_build_query([
            'APIKey' => $this->apiKey,
            'RequestId' => $request_id,
        ]);

        $response = json_decode($this->sendRequest('GET', 'checkcard?' . $query, []));
        $data = (array)$response->data;

        return json_encode([
            'status' => $response->status,
            'message' => $response->message,
            'data' => $response->status == 200 ? [
                'telco' => $data['NetworkCode'],
                'amount' => $data['PricesValue'],
                'amount_received' => $data['Value_Receive'],
                'amount_customer_received' => $data['Value_Customer_Receive'],
                'serial' => $data['SeriCard'],
                'pin' => $data['NumberCard'],
                'status' => $data['Status'],
                'request_id' => $data['RequestId'],
                'created_at' => $data['CreatedDate'],

            ] : null,
        ], JSON_UNESCAPED_UNICODE);
    }

    /**
     * @param string $method
     * @param string $action
     * @param array $data
     * @return bool|string
     */
    private function sendRequest(string $method, string $action, array $data): bool|string
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->apiUrl . $action,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_POSTFIELDS => json_encode($data),
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json'
            ]
        ));

        $response = curl_exec($curl);
        curl_close($curl);

        return $response;
    }

    /**
     * @param string $telco
     * @param int $amount
     * @param string $serial
     * @param string $pin
     * @param string $requestId
     * @param string $callbackUrl
     * @return void
     */
    public function setExchangeData(string $telco, int $amount, string $serial, string $pin, string $requestId, string $callbackUrl): void
    {
        $this->telco = $telco;
        $this->amount = $amount;
        $this->serial = $serial;
        $this->pin = $pin;
        $this->requestId = $requestId;
        $this->callbackUrl = $callbackUrl;
    }
}