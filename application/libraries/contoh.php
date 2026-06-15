<?php
include('BRI.php');

$conf = [
   'username' => 'user123',
   'password' => 'password123',
   'account'  => '4290xxxxxx',
   'date_start' => '2021/08/20',
   'date_end' => '2021/09/17'
];

$bri = new BRI($conf);
$mut = $bri->getMutation();
print_r($mut);
