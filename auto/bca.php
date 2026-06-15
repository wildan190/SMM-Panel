<?php
date_default_timezone_set('Asia/Jakarta');
/*
Auto Check BCA 
*/
function toIDR($money)
{
    $m = explode('.', $money);
    return str_replace(',', '', $m[0]);
}

function fix_angka($string)
{
    $string = str_replace(',', '', $string);
    $string = strtok($string, '.');
    return $string;
}

function fetchResponseFrom($str)
{
    //file_put_contents(date('d-m-y h:i:s.html'), $str);
    $exp = explode('<table border="0" cellpadding="0" cellspacing="0" width="590">', $str);
    $exp = explode('</table>', $exp[2]);
    $all = explode('<font face="verdana" size="1" color="#0000bb">', $exp[1]);

    $strings = [];
    foreach ($all as $el) {
        $strings[] = trim(strip_tags($el));
    }

    $col = [];
    $total = count($strings) - 1;
    $cIt = 0;
    for ($it = 1; $total >= $it; $it++) {
        if ($it % 6 == 0) {
            $col[$cIt][] = $strings[$it];
            $cIt++;
        } else {
            $col[$cIt][] = $strings[$it];
        }
    }

    $result = array_map(function ($r) {
        return [
            'tgl'         => $r[0],
            'keterangan'  => preg_replace('/\s+/', ' ', $r[1]),
            'cabang'      => $r[2],
            'mutasi'      => fix_angka($r[3]),
            'jenis'       => $r[4],
            'saldo'       => $r[5]
        ];
    }, $col);
    return $result;
}
function login($url, $id, $pw, $serv, $agent)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, "value(actions)=login&value(user_id)=$id&value(user_ip)=$serv&value(browser_info)=$agent&value(mobile)=true&value(pswd)=$pw&value(Submit)=LOGIN");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $headers = array();
    $headers[] = "Origin: https://ibank.klikbca.com";
    $headers[] = "Accept-Encoding: gzip, deflate, br";
    $headers[] = "Accept-Language: id-ID,id;q=0.8,en-US;q=0.6,en;q=0.4";
    $headers[] = "Upgrade-Insecure-Requests: 1";
    $headers[] = "User-Agent: Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/59.0.3071.115 Safari/537.36";
    $headers[] = "Content-Type: application/x-www-form-urlencoded";
    $headers[] = "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8";
    $headers[] = "Cache-Control: max-age=0";
    $headers[] = "Referer: https://ibank.klikbca.com/authentication.do";
    $headers[] = "Connection: keep-alive";
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_COOKIEJAR, "bca.txt");
    $data = curl_exec($ch);
    if (curl_errno($ch)) {
        echo 'Error:' . curl_error($ch);
    }
    curl_close($ch);
    return $data;
}
function mutasi($url, $norek, $tgl, $bln, $thn, $etgl, $ebln, $ethn, $agent)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, "value(D1)=$norek&value(r1)=1&value(startDt)=$tgl&value(startMt)=$bln&value(startYr)=$thn&value(endDt)=$etgl&value(endMt)=$ebln&value(endYr)=$ethn&value(fDt)=&value(tDt)=&value(submit1)=Lihat Mutasi Rekening");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $headers = array();
    $headers[] = "Origin: https://ibank.klikbca.com";
    $headers[] = "Accept-Encoding: gzip, deflate, br";
    $headers[] = "Accept-Language: id-ID,id;q=0.8,en-US;q=0.6,en;q=0.4";
    $headers[] = "Upgrade-Insecure-Requests: 1";
    $headers[] = "User-Agent: Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/59.0.3071.115 Safari/537.36";
    $headers[] = "Content-Type: application/x-www-form-urlencoded";
    $headers[] = "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8";
    $headers[] = "Cache-Control: max-age=0";
    $headers[] = "Referer: https://ibank.klikbca.com/accountstmt.do?value(actions)=acct_stmt";
    $headers[] = "Connection: keep-alive";
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_COOKIEFILE, "bca.txt");
    $data = curl_exec($ch);
    if (curl_errno($ch)) {
        echo 'Error:' . curl_error($ch);
    }
    curl_close($ch);
    return $data;
}
function saldo($url)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://ibank.klikbca.com/balanceinquiry.do");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $headers = array();
    $headers[] = "Origin: https://ibank.klikbca.com";
    $headers[] = "Accept-Encoding: gzip, deflate, br";
    $headers[] = "Accept-Language: id-ID,id;q=0.8,en-US;q=0.6,en;q=0.4";
    $headers[] = "Upgrade-Insecure-Requests: 1";
    $headers[] = "User-Agent: Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/59.0.3071.115 Safari/537.36";
    $headers[] = "Content-Type: application/x-www-form-urlencoded";
    $headers[] = "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8";
    $headers[] = "Cache-Control: max-age=0";
    $headers[] = "Referer: https://ibank.klikbca.com/nav_bar_indo/account_information_menu.htm";
    $headers[] = "Connection: keep-alive";
    $headers[] = "Content-Length: 0";
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_COOKIEFILE, "bca.txt");
    $data = curl_exec($ch);
    if (curl_errno($ch)) {
        echo 'Error:' . curl_error($ch);
    }
    curl_close($ch);
    return $data;
}
function logout($url)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $headers = array();
    $headers[] = "Origin: https://ibank.klikbca.com";
    $headers[] = "Accept-Encoding: gzip, deflate, br";
    $headers[] = "Accept-Language: id-ID,id;q=0.8,en-US;q=0.6,en;q=0.4";
    $headers[] = "Upgrade-Insecure-Requests: 1";
    $headers[] = "User-Agent: Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/59.0.3071.115 Safari/537.36";
    $headers[] = "Content-Type: application/x-www-form-urlencoded";
    $headers[] = "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8";
    $headers[] = "Cache-Control: max-age=0";
    $headers[] = "Referer: https://ibank.klikbca.com/top.htm";
    $headers[] = "Connection: keep-alive";
    $headers[] = "Content-Length: 0";
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_COOKIEFILE, "bca.txt");
    curl_setopt($ch, CURLOPT_COOKIEJAR, "bca.txt");
    $result = curl_exec($ch);
    if (curl_errno($ch)) {
        echo 'Error:' . curl_error($ch);
    }
    curl_close($ch);
    if ($result) {
        unlink('bca.txt');
        $data = $result;
    }
    return $data;
}
function getStr($string, $start, $end)
{
    $str = explode($start, $string);
    $str = explode($end, $str[1]);
    return $str[0];
}
function checkkata($teks, $ckata)
{
    $carikata = array($ckata);
    $hasil = 0;
    $jml_kata = count($carikata);
    for ($i = 0; $i < $jml_kata; $i++) {
        if (stristr($teks, $carikata[$i])) {
            $hasil = 1;
        }
    }
    return $hasil;
}

// Execute
$agent = "Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/59.0.3071.115 Safari/537.36";
$id = '-';
$pw = '-';
$serv = '45.130.231.212';
$hari_ini = date("Y-n-d");
$tgl_pertama = date('Y-n-01', strtotime($hari_ini));
$tanggal = explode('-', $tgl_pertama);
$etanggal = explode('-', $hari_ini);
$tgl = $tanggal[2];
$bln = $tanggal[1];
$thn = $tanggal[0];
$etgl = $etanggal[2];
$ebln = $etanggal[1];
$ethn = $etanggal[0];
$norek = '8200819846';
$login = login("https://ibank.klikbca.com/authentication.do", $id, $pw, $serv, $agent);
$cekmutasi = mutasi("https://ibank.klikbca.com/accountstmt.do?value(actions)=acctstmtview", $norek, $tgl, $bln, $thn, $etgl, $ebln, $ethn, $agent);
$ceksaldo2 = saldo("https://ibank.klikbca.com/balanceinquiry.do");
$saldo4 = getStr($ceksaldo2, '<div align="right">', '</font>');
$ceksaldo = trim($saldo4);
$saldo3 = getStr($ceksaldo, '<font face="Verdana" size="2" color="#0000bb">', '</font>');
$saldo2 = str_replace(".", "", $saldo3);
$saldo1 = str_replace(",", "", $saldo2);
$saldo = substr($saldo1, 0, -2);
$logout = logout("https://ibank.klikbca.com/authentication.do?value(actions)=logout");
$tanggal_now = date('Y-m-d H:i:s');
echo json_encode(fetchResponseFrom($cekmutasi));
