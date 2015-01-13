<?php defined('SYSPATH') or die('No direct script access.');
/*
 * Пользователи
 */
class Controller_Admin_Roles extends Controller_Admin {
    
    public function before() {
        parent::before();
                
        //загрузка языкового файла
        i18n::lang('admin/'.$this->language_folder.'/roles');
        
        // Вывод в шаблон
        $this->template->page_title = __('heading_title');
        $this->template->page_url[] = HTML::anchor('admin/roles', $this->template->page_title);
    }
    
    public function action_index() {
        $this->message = $this->session->get("message");
        $this->session->set('message', null);
        $this->errors = $this->session->get("errors");
        $this->session->set('errors', null);


        $text = Array(
            'column_action'         => __('column_action'),
            'column_name'           => __('column_name'),
            'message_no'            => __('message_no'),

            'confim_delete'         => __('confim_delete'),
            'button_change'         => __('button_change'),
            'button_remove'         => __('button_remove'),
            'button_add'            => __('button_add'),
            'button_status'          => __('button_status'),
        );
        

        $sort = (string) $this->request->param('sort');
        $type = (string) $this->request->param('type');
        
        //установка значений для выборки из базы по-умолчанию
        if($sort == "") $sort = "id";
        if($type == "") $type = "desc";

        //извлекаем пользователей
        $roles = ORM::factory('Admin_Role')
            ->order_by($sort, $type)
            ->find_all();
    
        //формируем значения для шаблона
        $content = View::factory($this->template_admin.'roles/v_roles_list')
            ->bind('box_title',$this->template->page_title)
            ->bind('message', $this->message) 
            ->bind('errors', $this->errors)
            ->bind('roles', $roles)
            ->bind('type', $type)
            ->bind('sort', $sort)
            ->bind('text', $text);
        
        // Вывод в шаблон
        $this->template->block_center = array($content);
    }
    
	//Удаление ролей
    public function action_delete() {
    	if(!$this->validateModify()){
    		$this->session->set('errors', __('error_permission'));	
    	}
    	else{
    		//Извлечение данных
    		$selected = $this->request->post("selected");    
    		if(isset($selected)){ 
    		    //перебираем все роли и удаляем
    		    foreach($selected as $id){
    		        if($id != 0){ 
    				
    		            $role = ORM::factory('Admin_Role')->where('id', '=', $id)->find(); //извлекаем роль
    			        $count = $role->users->count_all();
                        if($count == 0){
                            $role->delete();        //удаляем  из базы
                        }
    		            else{
    				        $this->session->set('errors', __('error_delete').$count);
    				        HTTP::redirect('admin/roles');
    			        }
    		        }
    		    }
    		    $this->session->set('message', __('message_delete'));
    		}
    	}
        HTTP::redirect('admin/roles');
    }

    public function action_edit() {
        //если нажата кнопка сохранить
        if (isset($_POST['action']) && $_POST['action'] == "edit" && $this->validateModify())
        { 
            //Извлечение данных
            $this->data = Arr::extract($_POST, array('id', 'name', 'action', 'permission'));
	    
		      //загрузка модели
            $role = ORM::factory('Admin_Role', $this->data['id']);
            $role->name = $this->data['name'];
	        $role->description = $this->data['name'];
	        $role->permission = serialize($this->data['permission']);
            
            //проверка на валидацию
            try {
                $role->check();
            }
            catch(ORM_Validation_Exception $e)
            {
                $this->errors = $e->errors('admin/'.$this->language_folder);
            }
	   
	    //если все ок, то сохраняем
            if(empty($this->errors)){ 
                $role->save();   
                $this->session->set('message', __('message_edit'));
                HTTP::redirect('admin/roles'); 
            } 
        }

        //получаем контент
        $content = $this->getContent();
        
        // Вывод в шаблон
        $this->template->page_title .= __('heading_title_edit');
        $this->template->block_center = array($content);
    }

    public function action_add() {
        
        //если нажата кнопка сохранить
        if (isset($_POST['action']) && $_POST['action'] == "add" && $this->validateModify())
        { 
            
	       //Извлечение данных
            $this->data = Arr::extract($_POST, array('id', 'name', 'action', 'permission'));
	    
		  //загрузка модели
            $role = ORM::factory('Admin_Role');
            $role->name = $this->data['name'];
	        $role->description = $this->data['name'];
	        $role->permission = serialize($this->data['permission']);
            
            //проверка на валидацию
            try {
                $role->check();
            }
            catch(ORM_Validation_Exception $e)
            {
                $this->errors = $e->errors('admin/'.$this->language_folder);
            }
	   
	       //если все ок, то сохраняем
            if(empty($this->errors)){ 
                $role->save();   
                $this->session->set('message', __('message_add'));
                HTTP::redirect('admin/roles'); 
            }  	

        }

        $content = $this->getContent();
        
        // Вывод в шаблон
        $this->template->page_title .= __('heading_title_add');
        $this->template->block_center = array($content);
    }

    //функция формирования данных для шаблона
    private function getContent(){
        
        $id = (int) $this->request->param('id');

        $ignore = array(
			'Admin/Image',
			'Admin/Auth',
			'Admin/Errors',
			'Admin/Widgets',
			'Admin/Feeds',
            'Admin/Sitemap',
		);    
        
        $permissions = array(
            "all"       => "",
            "access"    =>  array(),
            "modify"    =>  array(),
            "title"     =>  "",
        );
		
        //извлекаем все контроллеры админки
		$files = glob(APPPATH.'classes/Controller/Admin/*.php');
		
		foreach ($files as $file) {
			
            $data = explode('/', dirname($file));
            i18n::lang('admin/'.$this->language_folder.'/'.basename($file, '.php'));
            
			$permission = end($data) . '/' . basename($file, '.php');
			
            if (!in_array($permission, $ignore)) {
				$permissions['all'][] = $permission;
                $permissions['title'][] = __('heading_title');
			}
		}
        
        //извлекаем все виджеты админки
        $files = glob(APPPATH.'classes/Controller/Admin/Widgets/*.php');
		
		foreach ($files as $file) {
              
			$data = explode('/', dirname($file));
            i18n::lang('admin/'.$this->language_folder.'/widgets/'.basename($file, '.php')); 
			$permission = 'Admin/'.end($data) . '/' . basename($file, '.php');
			if (!in_array($permission, $ignore)) {
				$permissions['all'][] = $permission;
                $permissions['title'][] = __('heading_title')."  (widget)";
			}
		}
        
	//извлекаем все каналы продвижения админки
        $files = glob(APPPATH.'classes/Controller/Admin/Feeds/*.php');
		
		foreach ($files as $file) {

			$data = explode('/', dirname($file));
            i18n::lang('admin/'.$this->language_folder.'/feeds/'.basename($file, '.php')); 
			$permission = 'Admin/'.end($data) . '/' . basename($file, '.php');
			if (!in_array($permission, $ignore)) {
				$permissions['all'][] = $permission;
                $permissions['title'][] = __('heading_title')."  (feed)";
			}
		}
        i18n::lang('admin/'.$this->language_folder.'/roles');
        
        $text = array(
            'entry_name'            => __('entry_name'),
            'entry_access'          => __('entry_access'),
            'entry_modify'          => __('entry_modify'),
            'button_save'   	    => __('button_save'),
            'button_abort'          => __('button_abort'),
            'text_select_all'       => __('text_select_all'),
            'text_select_remove'    => __('text_select_remove'),
        );
        
        //если post не пустой
        if(!empty($this->data)){ 
           $permissions['access'] = isset($this->data['permission']['access']) ? $this->data['permission']['access'] : array();
           $permissions['modify'] = isset($this->data['permission']['modify']) ? $this->data['permission']['modify'] : array();
        }
        
        //если post пустой и существует id  
        if(empty($this->data) && $id)
        {
           $role = ORM::factory('Admin_Role', $id); 
	       $permission = unserialize($role->permission);
	   
    	   if(isset($permission['access']))
    		  $permissions['access'] = $permission['access'];
    	  
    	   
    	   if(isset($permission['modify']))
    		  $permissions['modify'] = $permission['modify'];

    		
    	   $this->data = array(
                   "action" => "edit",
                   "name"   => $role->name,
                   "id" => $role->id,
               ); 
	   
        }
        
        //если post пустой, и не существует id
        if(empty($this->data) && !$id){ 
           $this->data = array(
               "action" => "add",
               "name"   => "",
               "id" => 0,
           ); 
        }

        //формируем весь контент
        $content = View::factory($this->template_admin.'roles/v_roles_form')
                ->bind('box_title',$this->template->page_title)
                ->bind('errors', $this->errors) //ошибки
                ->bind('permissions', $permissions) //массив пользователя
                ->bind('text', $text) //массив текста для полей
                ->bind('roles', $roles_arr) //массив ролей
                ->bind('data', $this->data);    //передаваемые данные
                        
        return $content;
    }    

	
}
