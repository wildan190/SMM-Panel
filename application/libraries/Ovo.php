<?php

class Ovo
{
    public $nomor;
    public $device;

    public function getDevice()
    {
        $deviceId = rand(111,999).'ff'.rand(111,999).'-b7fc-3b'.rand(11,99).'-b'.rand(11,99).'d-'.rand(1111,9999).'d2fea8e5';
        return $deviceId;
    }

    public function sendRequest2FA($nomor, $device)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://api.ovo.id/v1.1/api/auth/customer/login2FA");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, '{"deviceId":"'.$device.'","mobile":"'.$nomor.'"}');
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'App-Version: 3.71.0',
            'Os: Android',
            'Content-Type: application/json; charset=UTF-8',
            'Host: api.ovo.id',
            'User-Agent: okhttp/3.71.0',
        ]);
        $result = curl_exec($ch);
        $reshttp = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        return $result;
    }

    public function konfirmasiCode($nomor, $device, $verificationCode)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_PROXY, "proxy.rapidplex.com:3128");
        curl_setopt($ch, CURLOPT_PROXYUSERPWD, "user:domainesia");
        curl_setopt($ch, CURLOPT_URL, "https://api.ovo.id/v1.1/api/auth/customer/login2FA/verify");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, '{"deviceId":"'.$device.'","mobile":"'.$nomor.'","verificationCode":"'.$verificationCode.'"}');
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'App-Version: 3.18.0',
            'Os: Android',
            'Content-Type: application/json; charset=UTF-8',
            'Host: api.ovo.id',
            'User-Agent: okhttp/3.31.0',
        ]);
        $result = curl_exec($ch);
        curl_close($ch);
        if (json_decode($result, true)['isSecurityCode']  ==  'true') {
            return true;
        } else {
            return false;
        }
    }

    public function konfirmasiSecurityCode($nomor, $device, $securityCode)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_PROXY, "proxy.rapidplex.com:3128");
        curl_setopt($ch, CURLOPT_PROXYUSERPWD, "user:domainesia");
        curl_setopt($ch, CURLOPT_URL, "https://api.ovo.id/v1.1/api/auth/customer/loginSecurityCode/verify");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, '{"mobile":"'.$nomor.'","securityCode":"'.$securityCode.'","deviceUnixtime":1539175105,"appVersion":"3.16.0","deviceId":"'.$device.'","macAddress":"08:62:66:67:81:39","osName":"android","osVersion":"5.0","pushNotificationId":"FCM|e1-j8yB55QI:APA91bFan4mLCWogE4ols2OFSmz1YjgB71tKwZA0Y-IkwJSiKzG1ALJ6oxGuSQLYXLQWG8dujmdeWOdPn-gWWc_0fDcaO8BaPeZQbiF9wd3pfFU1NcYv54CUU80yPAZMS0nbNqfgHosJ"}');
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'App-Version: 3.18.0',
            'Os: Android',
            'Content-Type: application/json; charset=UTF-8',
            'Host: api.ovo.id',
            'User-Agent: okhttp/3.31.0',
        ]);
        $result = json_decode(curl_exec($ch), true);
        $reshttp = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        return ($reshttp == 200) ? ['status' => true,'data' => $result['token']] : ['status' => false,'data' => $result['message']];
    }

    public function seeMutation($access_token,$limit = 10)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_PROXY, "proxy.rapidplex.com:3128");
        curl_setopt($ch, CURLOPT_PROXYUSERPWD, "user:domainesia");
        curl_setopt($ch, CURLOPT_URL, "https://api.ovo.id/wallet/v2/transaction?page=1&limit=".$limit."&productType=001");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: '.$access_token,
            'App-Version: 3.18.0',
            'Os: Android',
            'Host: api.ovo.id',
            'User-Agent: okhttp/3.31.0',
        ]);
        $res = curl_exec($ch);
        $result = json_decode($res, true);
        curl_close($ch);

        $http = ($result['status'] == 200) ? true : false;
        $data = ($result['status'] == 200) ? $result['data'][0]['complete'] : $result['message'];
        return json_encode($data, JSON_PRETTY_PRINT);
    }

    public function cekSaldo($saldo, $mutasi)
    {
        return (strpos($mutasi, $saldo) !== false) ? true : false;
    }
}
