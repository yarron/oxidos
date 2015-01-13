<?php defined('SYSPATH') OR die('No direct access allowed.');

$config = kohana::$config->load('config');

//native, sendmail, smtp

if($config->get('mail_protocol') == "smtp"){
    return array(
    	'driver' => "smtp",
    	'options' => array(
            'hostname'      => $config->get('smtp_host'),
            'username'      => $config->get('smtp_login'),
            'password'      => $config->get('smtp_password'),
            'port'          => $config->get('smtp_port'),
        )
    ); 

}
else{
    return array(
    	'driver' => "native",
    	'options' => NULL 
    );
}

