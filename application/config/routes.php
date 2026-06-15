<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'auth';
$route['404_override'] = '';
$route['translate_uri_dashes'] = TRUE;

$route['deposit/new'] = 'deposit/baru';
$route['(.*)\.php'] = '$1';
