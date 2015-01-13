<?php defined('SYSPATH') or die('No direct script access.');

// Catch-all route for Install classes to run
Route::set('install', 'install(/<lang>(/step_<step>))')
	->defaults(array(
		'controller' => 'install',
		'action' => 'index',
		'step' => NULL,
        'lang' => 'ru',
        ));
