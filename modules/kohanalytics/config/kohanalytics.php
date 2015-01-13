<?php defined('SYSPATH') or die('No direct access allowed.');
$config =  kohana::$config->load('config');

return array
(
	'username'     => $config->get('google_login'),
	'password'     => $config->get('google_password'),
	'report_id'    => $config->get('google_report_id'),
);