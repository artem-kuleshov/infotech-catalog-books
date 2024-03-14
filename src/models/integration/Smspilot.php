<?php


namespace app\models\integration;


use GuzzleHttp\Client;

class Smspilot
{
    /**
     * @var Client
     */
    private $http;

    public function __construct()
    {
        $this->http = new Client([
            'base_uri' => 'https://smspilot.ru/api2.php',
            'verify' => false
        ]);
    }

    /**
     * @param array $phones_text - ['phone' => '89999999999', 'text' => 'text']
     *
     * @return mixed
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     *
     */
    public function send(array $phones_text)
    {
        $send = [];
        foreach ($phones_text as $key => $data) {
            $send[] = ['id' => $key, 'to' => $data['phone'], 'text' => $data['text']];
        }

        $json = [
            'apikey' => \Yii::$app->params['smspilotToken'],
            'from' => 'INFORM',
            'send' => $send
        ];

        $response = $this->http->post("", ['json' => $json]);
        return json_decode($response->getBody()->getContents(), true);
    }
}