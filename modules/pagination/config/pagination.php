<?php defined('SYSPATH') or die('No direct script access.');

return array(

	// Application defaults
	'default' => array(
		'current_page'      => array('source' => 'route', 'key' => 'page'), 
		'total_items'       => 0,
		'items_per_page'    => 25,
		'view'              => 'pagination/index',
		'auto_hide'         => true,
		'first_page_in_url' => false,
	),

);

