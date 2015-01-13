<?php defined('SYSPATH') or die('No direct access allowed.');

class Controller_Install extends Kohana_Controller_Template {
	public $template = 'install';
    private $errors = "";
    private $success = "";
    private $text = array();
    private $data = array();
    private $errors_arr = array();
    private $lang;
    private $redirect;
    //функция установки Oxidos
	public function action_index()
	{
          
          if($this->request->post('language_code')){
            $this->lang = $this->request->post('language_code');
            HTTP::redirect('install/'.$this->lang.$this->request->post('redirect')); 
          }
          else
            $this->lang = (string)$this->request->param('lang');
        
          i18n::lang($this->lang.'/install');
          $step = (int)$this->request->param('step');
          if(!$step) $step=1;
          
          
          if($this->request->post() && $this->validate($step) && !$this->request->post('language_code')){
                
                switch($step){
                    case 1: HTTP::redirect('install/'.$this->lang.'/step_2'); break;
                    case 2: HTTP::redirect('install/'.$this->lang.'/step_3'); break;
                    case 3: 
                        $model = Model::factory('Install');
                        
                        $result = $model->mysql($this->data);

                        if($result == "success"){
                            $output  = "<?php defined('SYSPATH') or die('No direct access allowed.');" . "\n\n";
                			$output .= "return array" . "\n(\n";
                			$output .= "\t'default' => array" . "\n\t(\n";
                			$output .= "\t\t'type'       => 'MySQLi'," . "\n";
                			$output .= "\t\t'connection' => array(" . "\n";
                            $output .= "\t\t\t'hostname'   => '".$this->data['db_host']."'," . "\n";
                            $output .= "\t\t\t'database'   => '".$this->data['db_name']."'," . "\n";
                            $output .= "\t\t\t'username'   => '".$this->data['db_user']."'," . "\n";
                            $output .= "\t\t\t'password'   => '".$this->data['db_password']."'," . "\n";
                            $output .= "\t\t\t'port' 	   => NULL," . "\n";
							$output .= "\t\t\t'socket' 	   => NULL," . "\n\t\t),\n";
                            $output .= "\t\t'table_prefix' => '".$this->data['db_prefix']."'," . "\n";
                            $output .= "\t\t'charset'      => 'utf8'," . "\n";
                            $output .= "\t\t'caching'      => TRUE," . "\n";
                            $output .= "\n\t),\n);\n";
                            
                			$file = fopen(APPPATH . 'config/database.php', 'w');
                			fwrite($file, $output);
                			fclose($file);
                            
                            HTTP::redirect('install/'.$this->lang.'/step_4'); 
                        }
                        elseif($result == "error_connect") $this->errors = __('step3_error_connect');
                        elseif($result == "error_load_file") $this->errors = __('step3_error_load_file');
                        else $this->errors = __('step3_error');
                        break;
                    
                }  
          }
          $this->text = array(
                'text_title'        => __('text_title'),
                'text_doc'          => __('text_doc'),
                'text_copy'         => __('text_copy'),
                'text_license'      => __('text_license'),
                'text_install'      => __('text_install'),
                'text_config'       => __('text_config'),
                'text_final'        => __('text_final'),

                'button_continue'   => __('button_continue'),
                'button_back'       => __('button_back'),
          );
          
          $languages = array(
            'ru'    => array('code'=> 'ru', 'name' => 'Russian'),
            'en'    => array('code'=> 'en', 'name' => 'English'),
          );
          
          switch($step){
                case 1: $this->template->content = $this->step1(); break;
                case 2: $this->template->content = $this->step2(); break;
                case 3: $this->template->content = $this->step3(); break;
                case 4: $this->template->content = $this->step4(); break;
          }
          
          $this->template->languages = $languages;
          $this->template->redirect = $this->redirect;    
          $this->template->step = $step;
          $this->template->lang = $this->lang;
          $this->template->error_warning = $this->errors;
          $this->template->success = $this->success;
          $this->template->text = $this->text;
	}
    
    //первый шаг установки
    private function step1(){
       
        $entry = array(
            'step1_agree'             => __('step1_agree'),
            'step1_license'           => __('step1_license'), 
        );
        
        $this->redirect = '/step_1';
        
        $this->template->step_title = __('text_step_one');
        
        return View::factory('step1')
                ->bind('lang',         $this->lang)
                ->bind('entry',         $entry)
                ->bind('text',        $this->text);
                
    }
    
    //второй шаг установки
    private function step2(){
        $entry = array(
            'step2_current'             => __('step2_current'),
            'step2_necessary'           => __('step2_necessary'),
            'step2_state'               => __('step2_state'),
            'step2_config'              => __('step2_config'),
            'step2_config_php'          => __('step2_config_php'),
            'step2_extension'           => __('step2_extension'),
            'step2_extension_extension' => __('step2_extension_extension'),
            'step2_file'                => __('step2_file'),
            'step2_file_file'           => __('step2_file_file'),
            'step2_catelog'             => __('step2_catelog'),
            'step2_catelog_catalog'     => __('step2_catelog_catalog'),
            'step2_file_non'            => __('step2_file_non'),
            'step2_write'               => __('step2_write'),
            'step2_nowrite'             => __('step2_nowrite'),
        );
        
        $file = array(
            'bootstrap'     => APPPATH.'bootstrap.php',
            'database'      => APPPATH.'config/database.php',
        );

        $directory = array(
            'cache'         => APPPATH.'cache',
            'logs'          => APPPATH.'logs',
            'image'         => DOCROOT.'image',
            'image_cache'   => DOCROOT.'image/cache',
            'image_data'    => DOCROOT.'image/data',
            'downloads'     => DOCROOT.'downloads',
        );
        
        $this->template->step_title = __('text_step_two');
        $this->redirect = '/step_2';
        return View::factory('step2')
                ->bind('lang',          $this->lang)
                ->bind('directory',     $directory)
                ->bind('file',          $file)
                ->bind('entry',         $entry)
                ->bind('text',          $this->text);
                
    }
    
    //третий шаг установки
    private function step3(){
        $entry = array(
            'step3_db'                  => __('step3_db'),
            'step3_db_driver'           => __('step3_db_driver'),
            'step3_db_host'             => __('step3_db_host'),
            'step3_db_user'             => __('step3_db_user'),
            'step3_db_password'         => __('step3_db_password'),
            'step3_db_name'             => __('step3_db_name'),
            'step3_db_prefix'           => __('step3_db_prefix'),
            'step3_admin'               => __('step3_admin'),
            'step3_username'            => __('step3_username'),
            'step3_password'            => __('step3_password'),
            'step3_email'               => __('step3_email'),
        );
        
        if(empty($this->data)) {
            $this->data = array(
                'db_host'           =>'localhost',
                'db_user'             => '',
                'db_password'         => '',
                'db_name'             => '',
                'db_prefix'           => 'ox_',
                'username'            => '',
                'password'            => '',
                'email'               => '',
            );
        }

        $this->template->step_title = __('text_step_three');
        $this->redirect = '/step_3';
        return View::factory('step3')
                ->bind('lang',         $this->lang)
                ->bind('entry',         $entry)
                ->bind('errors',         $this->errors_arr)
                ->bind('data',        $this->data)
                ->bind('text',        $this->text);
                
    }
    
    //первый шаг установки
    private function step4(){
        $file_old = file_get_contents(APPPATH."bootstrap.php");
        $file_new = str_replace("'install'       => MODPATH.'install',", "//'install'       => MODPATH.'install',", $file_old);
        file_put_contents(APPPATH."bootstrap.php", $file_new);

        $entry = array(
            'step4_success'         => __('step4_success'),
            'step4_site'            => __('step4_site'), 
            'step4_admin'           => __('step4_admin'), 
        );

        $this->template->step_title = __('text_step_four');
        $this->redirect = '/step_4';
        $this->success = __('step4_error');
        return View::factory('step4')
                ->bind('entry',         $entry)
                ->bind('text',        $this->text);
                
    }
    
    private function validate($step){
        switch($step){
                case 1:
                    if($this->request->post('agree') != 1)                  $this->errors = __('step1_error');
                    break;
                case 2:
                    if (phpversion() < '5.3.3')                            $this->errors = __('step2_error_php');
            		if (ini_get('register_globals'))                        $this->errors = __('step2_error_globals');
                    if (ini_get('magic_quotes_gpc'))                        $this->errors = __('step2_error_quotes');
                    if (!ini_get('file_uploads'))                           $this->errors = __('step2_error_uploads');
                    if (!function_exists('ctype_digit'))                    $this->errors = __('step2_error_ctype');
                    if (!function_exists('filter_list'))                    $this->errors = __('step2_error_filter');
                    if (!class_exists('ReflectionClass'))                   $this->errors = __('step2_error_reflection');
                    if (!function_exists('spl_autoload_register'))          $this->errors = __('step2_error_spl');
                    if (!@preg_match('/^.$/u', 'ñ'))                        $this->errors = __('step2_error_utf8');
                    
                    if (!extension_loaded('mysql'))                         $this->errors = __('step2_error_mysql');
                    if (!extension_loaded('mysqli'))                        $this->errors = __('step2_error_mysqli');
                    if (!extension_loaded('PDO'))                           $this->errors = __('step2_error_pdo');
                    if (!extension_loaded('gd'))                            $this->errors = __('step2_error_gd');
                    if (!extension_loaded('curl'))                          $this->errors = __('step2_error_curl');
                    if (!function_exists('mcrypt_encrypt'))                 $this->errors = __('step2_error_mcrypt');
                    if (!extension_loaded('mbstring'))                      $this->errors = __('step2_error_mbstring');
                    if (!extension_loaded('iconv'))                         $this->errors = __('step2_error_iconv');
                    if (!extension_loaded('ionCube Loader'))                $this->errors = __('step2_error_ioncube');
                    
                    if (!file_exists(APPPATH.'bootstrap.php'))                $this->errors = __('step2_error_bootstrap');
           		    elseif (!is_writable(APPPATH.'bootstrap.php'))            $this->errors = __('step2_error_bootstrap_w');
            		if (!file_exists(APPPATH.'config/database.php'))        $this->errors = __('step2_error_db');
           		    elseif (!is_writable(APPPATH.'config/database.php'))    $this->errors = __('step2_error_db_w');
            		
                    if (!is_writable(APPPATH.'cache'))                      $this->errors = __('step2_error_cache');
                    if (!is_writable(APPPATH.'logs'))                       $this->errors = __('step2_error_logs');
                    if (!is_writable(DOCROOT.'image'))                      $this->errors = __('step2_error_image');
                    if (!is_writable(DOCROOT.'image/cache'))                $this->errors = __('step2_error_image_cache');
                    if (!is_writable(DOCROOT.'image/data'))                 $this->errors = __('step2_error_image_data');
                    
		            break;  
                case 3:
                    $this->data = Arr::extract($_POST, array('db_host','db_user','db_password', 'db_name', 'db_prefix', 'db_driver', 'username', 'password', 'email'));
                    $data = Validation::factory($this->data);

                    $data->rule('db_host', 'not_empty')->label('db_host' , __('step3_db_host'))
                         ->rule('db_user', 'not_empty')->label('db_user' , __('step3_db_user')) 
                         ->rule('db_name', 'not_empty')->label('db_name' , __('step3_db_name'))
                         ->rule('username', 'not_empty')->rule('username', 'alpha_dash')->rule('username', 'min_length', array(':value', 3))->label('username' , __('step3_username'))
                         ->rule('password', 'not_empty')->rule('password', 'alpha_dash')->rule('password', 'min_length', array(':value', 8))->label('password' , __('step3_password'))
                         ->rule('email', 'not_empty')->rule('email', 'email')->label('email' , __('step3_email'));
                         
                    if (!$data->check()){
                        $this->errors_arr = $data->errors('ru/install');
                        $this->errors = __('step3_error');
                    }
                    break;
        }

		if (!$this->errors) {
			return true;
		} else {
			return false;
		}
    }
}
