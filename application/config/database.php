<?php defined('SYSPATH') or die('No direct access allowed.');

return array
(
	'default' => array
	(
		'type'       => 'MySQLi',
		'connection' => array(
			'hostname'   => 'localhost',
			'database'   => 'test',
			'username'   => 'root',
			'password'   => '',
			'port' 	   => NULL,
			'socket' 	   => NULL,
		),
		'table_prefix' => 'ox_',
		'charset'      => 'utf8',
		'caching'      => TRUE,

	),
);
