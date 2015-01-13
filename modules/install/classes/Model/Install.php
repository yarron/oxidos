<?php defined('SYSPATH') or die('No direct script access.');

class Model_Install extends Model {
    public function mysql($data) {
       
		$config = array(
            'type'       => 'MySQLi',
            'connection' => array(
			     'hostname'   => $data['db_host'],
			     'database'   => $data['db_name'],
			     'username'   => $data['db_user'],
			     'password'   => $data['db_password'],
			     'port'       => NULL,
                 'socket'     => NULL
            ),
            'table_prefix' => $data['db_prefix'],
            'charset'      => 'utf8',
            'caching'      => FALSE,

        );
        
        $db = Database::instance('mysqli', $config);
        
        try
		{
			$db->connect();
		}
		catch (Exception $e)
		{
			return "error_connect";
		} 
        
			
		$file = MODPATH.'install/oxidos.sql';
		
		if (!file_exists($file)) { 
			return "error_load_file";
		}
		
		$lines = file($file);
		
		if ($lines) {
			$sql = '';

			foreach($lines as $line) {
				if ($line && (UTF8::substr($line, 0, 2) != '--') && (UTF8::substr($line, 0, 1) != '#')) {
					$sql .= $line;
  
					if (preg_match('/;\s*$/', $line)) {
						$sql = UTF8::str_ireplace("DROP TABLE IF EXISTS `ae_", "DROP TABLE IF EXISTS `" . $data['db_prefix'], $sql);
						$sql = UTF8::str_ireplace("CREATE TABLE `ae_", "CREATE TABLE `" . $data['db_prefix'], $sql);
						$sql = UTF8::str_ireplace("INSERT INTO `ae_", "INSERT INTO `" . $data['db_prefix'], $sql);
						
						$db->query('mysql',$sql);
	
						$sql = '';
					}
				}
			}
			
            $key1 = UTF8::substr(md5(uniqid(rand(), true)), 0, 9);
            $key2 = md5(mt_rand());

			$db->query('mysqli',"SET CHARACTER SET utf8");

			$db->query('mysqli',"DELETE FROM `" . $data['db_prefix'] . "settings` WHERE `config_key` = 'company_email'");
			$db->query('mysqli',"INSERT INTO `" . $data['db_prefix'] . "settings` SET `group_name` = 'config', `config_key` = 'company_email', config_value = 's:" .strlen($data['email']) . ":\"".$data['email']."\";'");

			$db->query('mysqli',"DELETE FROM `" . $data['db_prefix'] . "settings` WHERE `config_key` = 'hash_key'");
			$db->query('mysqli',"INSERT INTO `" . $data['db_prefix'] . "settings` SET `group_name` = 'config', `config_key` = 'hash_key', config_value = 's:" . strlen($key1) . ":\"".$key1."\";'");
			
			$db->query('mysqli',"DELETE FROM `" . $data['db_prefix'] . "settings` WHERE `config_key` = 'salt'");
			$db->query('mysqli',"INSERT INTO `" . $data['db_prefix'] . "settings` SET `group_name` = 'config', `config_key` = 'salt', config_value = 's:" . strlen($key2) . ":\"".$key2."\";'");
			
            $db->query('mysqli',"DELETE FROM `" . $data['db_prefix'] . "users` WHERE id = '1'");
			$db->query('mysqli',"INSERT INTO `" . $data['db_prefix'] . "users` SET id = '1',  username = '" . $data['username'] . "',  password = '" . hash_hmac('sha256',$data['password'] , $key1) . "', status = '1', email = '" . $data['email'] . "'");

            
		}
        return "success";		
	}	
 
} 