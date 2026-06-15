<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Midtrans
{
    private $server_key;
    private $client_key;
    private $is_production;
    private $api_url;

    public function __construct()
    {
        $this->is_production = false; // Set ke true untuk production
        
        if ($this->is_production) {
            $this->server_key = 'Mid-server-5a-zU6gBv1F67-YS3hFpj85i';
            $this->client_key = 'Mid-client-ESDOqJKEGYet1Y33';
            $this->api_url = 'https://app.midtrans.com/snap/v1/transactions';
        } else {
            $this->server_key = 'Mid-server-ySm0y0CubPUUITG-pDqiDgzJ';
            $this->client_key = 'Mid-client-B9QRofTzGGJZO4Mt';
            $this->api_url = 'https://app.sandbox.midtrans.com/snap/v1/transactions';
        }
    }

    public function getServerKey()
    {
        return $this->server_key;
    }

    public function getClientKey()
    {
        return $this->client_key;
    }

    public function isProduction()
    {
        return $this->is_production;
    }

    public function buildSnapParams(array $params, $notification_url = null)
    {
        if ($notification_url !== null && !isset($params['notification_url'])) {
            $params['notification_url'] = $notification_url;
        }

        return $params;
    }

    public function getSnapToken($params, $notification_url = null)
    {
        $payload = json_encode($this->buildSnapParams($params, $notification_url));
        $header = [
            'Content-Type: application/json',
            'Accept: application/json',
            'Authorization: Basic ' . base64_encode($this->server_key . ':')
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->api_url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        
        $response = curl_exec($ch);
        curl_close($ch);

        return json_decode($response, true);
    }
}
