<?php defined('SYSPATH') or die('No direct script access.');
/*
 * Страница изображений в загрузчике
 */

class Controller_Admin_Image extends Controller_Admin {
    public function  before() {
        parent::before();
        //загрузка языкового файла
        i18n::lang('admin/'.$this->config->get('admin_language_folder').'/image');
    }


    public function action_index() {

            $text = Array(
                    'heading_title'		=>__('heading_title'),

                    'text_uploaded'		=>__('text_uploaded'),
                    'text_create'		=>__('text_create'),
                    'text_delete'	    =>__('text_delete'),
                    'text_delete_file'  =>__('text_delete_file'),
                    'text_move'         =>__('text_move'),
                    'text_copy'         =>__('text_copy'),
                    'text_copy_file'    =>__('text_copy_file'),
                    'text_rename'		=>__('text_rename'),
                    'text_rename_file'	=>__('text_rename_file'),

                    'button_folder'		=>__('button_folder'),
                    'button_create'		=>__('button_create'),
                    'button_delete'		=>__('button_delete'),
                    'button_delete_file'=>__('button_delete_file'),
                    'button_copy'		=>__('button_copy'),
                    'button_copy_file'  =>__('button_copy_file'),
                    'button_rename'		=>__('button_rename'),
                    'button_rename_file'=>__('button_rename_file'),
                    'button_upload'		=>__('button_upload'),
                    'button_refresh'    =>__('button_refresh'),
                    'button_submit'		=>__('button_submit'),
                    'button_close'		=>__('button_close'),

                    'error_file'		=>__('error_file'),
                    'error_directory'   =>__('error_directory'),
                    'error_default'     =>__('error_default'),
                    'error_copy'		=>__('error_copy'),
                    'error_copy_file'	=>__('error_copy_file'),
                    'error_delete'		=>__('error_delete'),
                    'error_delete_file'	=>__('error_delete_file'),
                    'error_rename'      =>__('error_rename'),
                    'error_rename_file'      =>__('error_rename_file'),
                    'error_filename'    =>__('error_filename'),
                    'error_missing'		=>__('error_missing'),
                    'error_exists'      =>__('error_exists'),
                    'error_name'		=>__('error_name'),
                    'error_file_type'   =>__('error_file_type'),
                    'error_file_size'   =>__('error_file_size'),
                    'error_uploaded'    =>__('error_uploaded'),
                    'error_editor'      =>__('error_editor'),
                    'error_permission'  =>__('error_permission'),
    		);


            $field = arr::get($_POST, 'field');
            $thumb = arr::get($_POST, 'thumb');
            $editor = arr::get($_POST, 'editor');

    		if ($editor) {
    			$fckeditor = true;
    		} else {
    			$fckeditor = false;
    		}
            
            $data = array(
                'directory' => '/image/',
                'no_image'  => self::resizer('no_image.jpg', 150, 70),
                'field'     => $field,
                'fckeditor' => $fckeditor,
                'thumb'     => $thumb
            );
    	
    	    $content = View::factory($this->template_admin.'image/v_image')
                        ->bind('template',$this->template_admin)
                        ->bind('text', $text)
                        ->bind('data', $data);
     
            // Выводим в шаблон
            echo $content; die();
            
    }

    //предпросмотр
    public function action_preview(){
        if($this->request->is_ajax()){
            if (isset($_POST['title']) && isset($_POST['seo_title']) &&  isset($_POST['description'])) {
                $data = Arr::extract($_POST, array('title', 'seo_title', 'description'));
                $title      = __('heading_preview');
                $close      = __('button_close');
                $content = View::factory($this->template_admin.'preview/v_preview')
                    ->bind('title', $title)
                    ->bind('template', $this->template_index)
                    ->bind('close', $close)
                    ->bind('data', $data);
                echo $content; die();
            }
        }
    }

	public function action_image() {
        if($this->request->is_ajax()){

            $image = $_POST['image'];
    		if (isset($image)) {
    		      echo self::resizer(html_entity_decode($image, ENT_QUOTES, 'UTF-8'), 150, 100); die();
            }
        }
	}

    //показ всех папок дерева
    public function action_directory() {
        if($this->request->is_ajax()){

            $json = array(); //ответ
            $dir = arr::get($_POST,'dir'); //открываемая директория
            $parent = arr::get($_POST,'parent'); //родитель открываемой директории

            //если папка передана
            if (isset($dir)) {

                //если папка корневая, то выводим только её
                if(empty($dir)){
                    $directories = glob(UTF8::rtrim(DIR_IMAGE . 'data/' . UTF8::str_ireplace('../', '', $dir), '/') . '/*', GLOB_ONLYDIR);
                    $json['text'] = basename(DIR_IMAGE);
                    $json['children'] = count($directories)>0 ? true : false;
                    $json['li_attr']= array('data-parent' => 'data/');
                }
                else{ //иначе выводим содержимое
                    if($dir == basename(DIR_IMAGE)) $dir = ''; //если папка главная

                    //извлекаем все папки искомой директории
                    $directories = glob(UTF8::rtrim(DIR_IMAGE . $parent . UTF8::str_ireplace('../', '', $dir), '/') . '/*', GLOB_ONLYDIR);

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
    		
    		if (!empty($_POST['directory'])) {
    			$directory = DIR_IMAGE . UTF8::str_ireplace('../', '', $_POST['directory']);
    		} else {
    			$directory = DIR_IMAGE;
    		}
    		
    		$allowed = array('.jpg', '.jpeg', '.png', '.gif');
    		
    		$files = glob(UTF8::rtrim($directory, '/') . '/*');
    		
    		if ($files) {
    			ob_start();

    			foreach ($files as $file) {
    			    $info = @getimagesize($file); //проверка на корректность изображения
                    
    				if (is_file($file) && $info[0]) {
    					$ext = strrchr($file, '.');
    				} else {
    					$ext = '';
    				}	
    				
    				if (in_array(UTF8::strtolower($ext), $allowed)) {
    					$size = filesize($file);
    					$i = 0;
    					$suffix = array('B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');
    		
    					while (($size / 1024) > 1) {
    						$size = $size / 1024;
    						$i++;
    					}
    						
    					$json[] = array(
    						'filename' => basename($file),
    						'file'     => UTF8::substr($file, UTF8::strlen(DIR_IMAGE )),
    						'thumb'    => self::resizer(UTF8::substr($file, UTF8::strlen(DIR_IMAGE)), 150, 100),
    						'size'     => round(UTF8::substr($size, 0, UTF8::strpos($size, '.') + 4), 2) . $suffix[$i],
    					);
    				}
    			}
    			ob_end_clean();
    		}
    		echo json_encode($json); die();
        }
    }	
	
    //создание папки
	public function action_create() {
	   if($this->request->is_ajax()){
    		$json = array();
    		if (isset($_POST['directory'])) {
    			if (isset($_POST['name']) || $_POST['name']) {
    				$directory = UTF8::rtrim(DIR_IMAGE . UTF8::str_ireplace('../', '', $_POST['directory']), '/');
    				if (!is_dir($directory)) {
    					$json['error'] = __('error_directory');
    				}
    				if (file_exists($directory . '/' . UTF8::str_ireplace('../', '', $_POST['name']))) {
    					$json['error'] = __('error_exists');
    				}
    			} else {
    				$json['error'] = __('error_name');
    			}
    		} else {
    			$json['error'] = __('error_directory');
    		}
            
            /*if (!$this->checkPermission('modify', 'admin/image')) {
          			$json['error'] = __('error_permission');  
    		}*/
            
    		if (!isset($json['error'])) {	
    			mkdir($directory . '/' . UTF8::str_ireplace('../', '', $_POST['name']), 0777);
    			$json['success'] = __('text_create');
    		}	
    		
    		echo json_encode($json); die();
        }
	}
	
    //удаление файлов и папок
	public function action_delete() {
        if($this->request->is_ajax()){
    		$json = array();
    		
    		if (isset($_POST['path'])) {
    			$path = UTF8::rtrim(DIR_IMAGE . UTF8::str_ireplace('../', '', html_entity_decode($_POST['path'], ENT_QUOTES, 'UTF-8')), '/');
    			if (!file_exists($path)) {
    				$json['error'] = __('error_missing');
    			}
    			if ($path == UTF8::rtrim(DIR_IMAGE . 'data/', '/')) {
    				$json['error'] = __('error_delete');
    			}

    		} else {
    			$json['error'] = __('error_select');
    		}
    		
    		/*if (!$this->checkPermission('modify', 'admin/image')) {
          			$json['error'] = __('error_permission');  
    		}*/
    		
    		if (!isset($json['error'])) {
    			if (is_file($path)) {
    				unlink($path);
                    $json['success'] = __('text_delete_file');
    			} elseif (is_dir($path)) {
    				$this->recursiveDelete($path);
                    $json['success'] = __('text_delete');
    			}
    		}
    		echo json_encode($json); die();
        }
	}

    //рекурсивное удаление
	protected function recursiveDelete($directory) {
		if (is_dir($directory)) {
			$handle = opendir($directory);
		}
		if (!$handle) {
			return false;
		}
		
		while (false !== ($file = readdir($handle))) {
			if ($file != '.' && $file != '..') {
				if (!is_dir($directory . '/' . $file)) {
					unlink($directory . '/' . $file);
				} else {
					$this->recursiveDelete($directory . '/' . $file);
				}
			}
		}
		closedir($handle);
		rmdir($directory);
		return true;
	}

    //перемещение папки
	public function action_move() {
		if($this->request->is_ajax()){
    		$json = array();
    		
    		if (isset($_POST['from']) && isset($_POST['to'])) {
    			$from = UTF8::rtrim(DIR_IMAGE . UTF8::str_ireplace('../', '', html_entity_decode($_POST['from'], ENT_QUOTES, 'UTF-8')), '/');

    			if ($from == DIR_IMAGE . 'data') {
    				$json['error'] = __('error_default');
    			}
    			
    			$to = UTF8::rtrim(DIR_IMAGE . UTF8::str_ireplace('../', '', html_entity_decode($_POST['to'], ENT_QUOTES, 'UTF-8')), '/');
                if (is_dir($to . '/' . basename($from))) {
                    $json['error'] = __('error_exists');
                }

    			if (file_exists($to . '/' . basename($from))) {
    				$json['error'] = __('error_exists');
    			}
    		} else {
    			$json['error'] = __('error_directory');
    		}
    		
    		/*if (!$this->checkPermission('modify', 'admin/image')) {
          			$json['error'] = __('error_permission');  
    		}*/

    		if (!isset($json['error'])) {
    			rename($from, $to . '/' . basename($from));
    			$json['success'] = __('text_move');
    		}
    		echo json_encode($json); die();
        }
	}	
	
	//копирование файлов или папок
	public function action_copy() {
		if($this->request->is_ajax()){
    		$json = array();

            if (isset($_POST['from']) && isset($_POST['to'])) {
                $from = UTF8::rtrim(DIR_IMAGE . UTF8::str_ireplace('../', '', html_entity_decode($_POST['from'], ENT_QUOTES, 'UTF-8')), '/');

                if ($from == DIR_IMAGE . 'data') {
                    $json['error'] = __('error_default');
                }

                $to = UTF8::rtrim(DIR_IMAGE . UTF8::str_ireplace('../', '', html_entity_decode($_POST['to'], ENT_QUOTES, 'UTF-8')), '/');

                if (is_dir($to)) {
                    $json['error'] = __('error_exists');
                }

                if (is_file($from)) {
                    $ext = strrchr($from, '.');
                    $to = UTF8::str_ireplace($ext, '_',html_entity_decode($to, ENT_QUOTES, 'UTF-8')). $ext;
                }

    			if (file_exists($to)) {
    				$json['error'] = __('error_exists');
    			}
    		} else {
    			$json['error'] = __('error_select');
    		}
    		
    		/*if (!$this->checkPermission('modify', 'admin/image')) {
          			$json['error'] = __('error_permission');  
    		}	*/
    		//проверка на права
    		if (!isset($json['error'])) {
    			if (is_file($from)) {
    				copy($from, $to);
                    $json['success'] = __('text_copy_file');
    			} else {
    				$this->recursiveCopy($from, $to);
                    $json['success'] = __('text_copy');
    			}
    		}
    		
    		echo json_encode($json); die();	
        }
	}
	
	//рекурсивное копирование
	protected function recursiveCopy($source, $destination) {
		$directory = opendir($source);
		@mkdir($destination);
		while (false !== ($file = readdir($directory))) {
			if (($file != '.') && ($file != '..')) { 
				if (is_dir($source . '/' . $file)) { 
					$this->recursiveCopy($source . '/' . $file, $destination . '/' . $file); 
				} else { 
					copy($source . '/' . $file, $destination . '/' . $file); 
				} 
			} 
		}
		closedir($directory); 
	} 
    
	public function action_folders() {
	    if($this->request->is_ajax()){
		      echo $this->recursiveFolders(DIR_IMAGE . 'data/'); die();
        }
	}
	
	protected function recursiveFolders($directory) {
		$output = '';
		$output .= '<option value="' . UTF8::substr($directory, UTF8::strlen(DIR_IMAGE . 'data/')) . '">' . UTF8::substr($directory, UTF8::strlen(DIR_IMAGE . 'data/')) . '</option>';
		$directories = glob(UTF8::rtrim(UTF8::str_ireplace('../', '', $directory), '/') . '/*', GLOB_ONLYDIR);
		foreach ($directories  as $directory) {
			$output .= $this->recursiveFolders($directory);
		}
		return $output;
	}
	
    //переименование каталога или файла
	public function action_rename() {
		if($this->request->is_ajax()){
    		$json = array();
    		if (isset($_POST['path']) && isset($_POST['name'])) {
    			if ((UTF8::strlen($_POST['name']) < 3) || (UTF8::strlen($_POST['name']) > 255)) {
    				$json['error'] = __('error_filename');
    			}

    			$old_name = UTF8::rtrim(DIR_IMAGE .UTF8::str_ireplace('../', '', html_entity_decode($_POST['path'], ENT_QUOTES, 'UTF-8')), '/');

    			if (!file_exists($old_name) || $old_name == DIR_IMAGE . 'data') {
    				$json['error'] = __('error_rename');
    			}

    			if (is_file($old_name) && !strrchr($_POST['name'], '.')) {
    				$ext = strrchr($old_name, '.');
    			} else {
    				$ext = '';
    			}		

    			$new_name = dirname($old_name) . '/' . UTF8::str_ireplace('../', '', html_entity_decode($_POST['name'], ENT_QUOTES, 'UTF-8') . $ext);

    			if (file_exists($new_name)) {
    				$json['error'] = __('error_exists');
    			}			
    		}
    		
    		/*if (!$this->checkPermission('modify', 'admin/image')) {
          			$json['error'] = __('error_permission');  
    		}*/
    		
    		if (!isset($json['error'])) {
                if (is_file($old_name)) {
                    rename($old_name, $new_name);
                    $json['success'] = __('text_rename_file');
                } else {
                    rename($old_name, $new_name);
                    $json['success'] = __('text_rename');
                }

    		}
    		
    		echo json_encode($json); die();
        }
	}
	
	public function action_upload() {
		
		$json = array();
		if (isset($_POST['directory'])) {
			if (isset($_FILES['image']) && $_FILES['image']['tmp_name']) {
				$filename = basename(html_entity_decode($_FILES['image']['name'][0], ENT_QUOTES, 'UTF-8'));
                
                $imageinfo = getimagesize($_FILES['image']['tmp_name'][0]);
                
				if ((UTF8::strlen($filename) < 3) || (UTF8::strlen($filename) > 255)) {
					$json['error'] = __('error_filename');
				}
					
				$directory = UTF8::rtrim(DIR_IMAGE . UTF8::str_ireplace('../', '', $_POST['directory']), '/');
				
				if (!is_dir($directory)) {
					$json['error'] = __('error_directory');
				}
				
				if ($_FILES['image']['size'][0] > 3000000 || !$imageinfo[0]) {
					$json['error'] = __('error_file_size');
				}
				
				$allowed = array(
					'image/jpeg',
					'image/pjpeg',
					'image/png',
					'image/x-png',
					'image/gif',
					'application/x-shockwave-flash'
				);
						
				if (!in_array($_FILES['image']['type'][0], $allowed) || !in_array($imageinfo['mime'], $allowed)) {
					$json['error'] = __('error_file_type');
				}
				//************************
				$allowed = array(
                    '.mp4',
					'.jpg',
					'.jpeg',
					'.gif',
					'.png',
					'.flv'
				);
						
				if (!in_array(UTF8::strtolower(strrchr($filename, '.')), $allowed)) {
					$json['error'] = __('error_file_type');
				}

				if ($_FILES['image']['error'][0] != UPLOAD_ERR_OK) {
					$json['error'] = 'error_upload_' . $_FILES['image']['error'][0];
				}			
			} else {
				$json['error'] = __('error_file');
			}
		} else {
			$json['error'] = __('error_directory');
		}
		
		/*if (!$this->checkPermission('modify', 'admin/image')) {
          			$json['error'] = __('error_permission');  
		}*/
		
		if (!isset($json['error'])) {	
			if (@move_uploaded_file($_FILES['image']['tmp_name'][0], $directory . '/' . $filename)) {
				$json['success'] = __('text_uploaded');
			} else {
				$json['error'] = __('error_uploaded');
			}
		}
        header("Content-Type: application/json; charset=UTF-8");
        echo json_encode($json); die();
        
	}

}
