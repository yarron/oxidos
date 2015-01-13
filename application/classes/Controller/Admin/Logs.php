<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Logs extends Controller_Admin {
    public function before() {
        parent::before();

        $this->template->styles[] = 'styles/admin/bower_components/jstree/dist/themes/default/style.min.css';
        $this->template->scripts[] = 'styles/admin/bower_components/jstree/dist/jstree.min.js';
        $this->template->scripts[] = 'styles/admin/bower_components/jquery.lazyload/jquery.lazyload.min.js';
        $this->template->scripts[] = 'styles/'.$this->template_admin . 'javascript/ajaxupload.js';
        
        //загрузка языкового файла
        i18n::lang('admin/'.$this->language_folder.'/logs');

        // Вывод в шаблон
        $this->template->page_title = __('heading_title');
        $this->template->page_url[] = HTML::anchor('admin/logs', $this->template->page_title);
    }

    //показ всех статей
    public function action_index() {
        $this->message = $this->session->get("message");
        $this->session->set('message', null);

        //ссылки для кнопок

        $text = Array(
            'text_delete'		=>__('text_delete'),
            'button_delete'     =>__('button_delete'),
            'error_select'		=>__('error_select'),
            'error_delete'		=>__('error_delete'),
            'error_permission'          =>__('error_permission'),
        );
        
            
        $data = array(
            'directory' => APPPATH . 'logs/',
            'thumb'     => $this->template_admin . 'image/php.png',
        );
            
        //формируем значения для шаблона
        $content = View::factory($this->template_admin.'logs/v_logs')
            ->bind('box_title',$this->template->page_title)
            ->bind('message', $this->message)
            ->bind('text', $text)
            ->bind('data', $data);
            
        // Вывод в шаблон
        $this->template->block_center = array($content);
    }

    
    
    //функция показа категорий
    public function action_directory() {
        if($this->request->is_ajax()){

            $json = array(); //ответ
            $dir = arr::get($_POST,'dir'); //открываемая директория
            $parent = arr::get($_POST,'parent'); //родитель открываемой директории

            //если папка передана
            if (isset($dir)) {

                //если папка корневая, то выводим только её
                if(empty($dir)){
                    $directories = glob(UTF8::rtrim(APPPATH . 'logs/' . UTF8::str_ireplace('../', '', $dir), '/') . '/*', GLOB_ONLYDIR);

                    $json['text'] = basename(APPPATH.'logs/');
                    $json['children'] = count($directories)>0 ? true : false;
                    $json['li_attr'] = array('data-parent' => 'logs/');
                }
                else{ //иначе выводим содержимое
                    if($dir == basename(APPPATH.'logs/')) $dir = ''; //если папка главная

                    //извлекаем все папки искомой директории
                    $directories = glob(UTF8::rtrim(APPPATH.$parent . UTF8::str_ireplace('../', '', $dir), '/') . '/*', GLOB_ONLYDIR);

                    //если папки найдены, то формируем ответ
                    if ($directories) {
                        $i = 0;
                        foreach ($directories as $directory) {
                            $subdir = glob(UTF8::rtrim($directory, '/') . '/*', GLOB_ONLYDIR); //сморим, а есть подпапки

                            $json[$i]['text'] = basename($directory);
                            $json[$i]['children'] = count($subdir) > 0 ? true : false;
                            $json[$i]['li_attr']= array('data-parent' => $dir!= '' ? $parent.$dir.'/': $parent); //атрибут для правильного поиска родителя

                            $i++;
                        }
                    }
                }
            }

            echo json_encode($json); die();
        }
    }
    
    //функция показа всех файлов категории
    public function action_files() {
	if($this->request->is_ajax()){
    		$json = array();

            $dir = arr::get($_POST,'directory'); //открываемая директория
            $parent = arr::get($_POST,'parent'); //родитель открываемой директории

    		if (!empty($dir))
    			$directory = APPPATH . $parent . UTF8::str_ireplace('../', '', $dir);
    		else 
    			$directory = APPPATH . 'logs/';
    		$allowed = array('.php');
    		
    		$files = glob(UTF8::rtrim($directory, '/') . '/*');

    		if ($files) {
    			ob_start();
    			foreach ($files as $file) {
    				if (is_file($file)) $ext = strrchr($file, '.');
    				else $ext = '';
    					
    				if (in_array(UTF8::strtolower($ext), $allowed)) {
    					$size = filesize($file);
    					$i = 0;
    					$suffix = array('B','KB','MB','GB','TB','PB','EB','ZB','YB');
    		
    					while (($size / 1024) > 1) {
    						$size = $size / 1024;
    						$i++;
    					}
    						
    					$json[] = array(
    						'filename' => basename($file),
    						'file'     => UTF8::substr($file, UTF8::strlen(APPPATH . 'logs/')),
    						'size'     => round(UTF8::substr($size, 0, UTF8::strpos($size, '.') + 4), 2) . $suffix[$i]
    					);
    				}
    			}
    			ob_end_clean();
    		}
    
    		echo json_encode($json); die();
        }
    }
    
    //функция показа содержимого лога
    public function action_log(){
        if($this->request->is_ajax()){
            $json = array();
            if (!empty($_POST['file'])){
                $json = file(APPPATH . 'logs/'.$_POST['file']);
            }
            echo json_encode($json); die();
        }
    }
    
    //функция удаление файлов и папок
    public function action_delete() {
        if($this->request->is_ajax()){
            $json = array();

            if (isset($_POST['path'])) {
                    $path = UTF8::rtrim(APPPATH . UTF8::str_ireplace('../', '', html_entity_decode($_POST['path'], ENT_QUOTES, 'UTF-8')), '/');
                    if (!file_exists($path)) $json['error'] = __('error_select');
                    if ($path == UTF8::rtrim(APPPATH . 'logs/', '/')) $json['error'] = __('error_delete');

            } else $json['error'] = __('error_select');

            if (!$this->checkPermission('modify', 'admin/logs'))
                $json['error'] = __('error_permission');

            if (!isset($json['error'])) {
                    if (is_file($path)) unlink($path);
                    elseif (is_dir($path)) $this->recursiveDelete($path);
                    $json['success'] = __('text_delete');
            }
            echo json_encode($json); die();
        }
    }

    //рекурсивное удаление
    protected function recursiveDelete($directory) {
        if (is_dir($directory)) $handle = opendir($directory);
        if (!$handle) return false;
        
        while (false !== ($file = readdir($handle))) {
                if ($file != '.' && $file != '..') {
                        if (!is_dir($directory . '/' . $file)) unlink($directory . '/' . $file);
                        else $this->recursiveDelete($directory . '/' . $file);
                }
        }
        closedir($handle);
        rmdir($directory);
        return true;
    }
}
