<?php defined('SYSPATH') or die('No direct script access.');
/*
 * Схемы
 */
class Controller_Admin_Layouts extends Controller_Admin {
    
    public function before() {
        parent::before();
                
        //загрузка языкового файла
        i18n::lang('admin/'.$this->language_folder.'/layouts');
        
        // Вывод в шаблон
        $this->template->page_title = __('heading_title');
        $this->template->page_url[] = HTML::anchor('admin/layouts', $this->template->page_title);
    }

    public function action_index() {
        $this->message = $this->session->get("message");
        $this->session->set('message', null);
        $this->errors = $this->session->get("errors");
        $this->session->set('errors', null);
        
        //ссылки для кнопок

        $text = Array(
            'column_action'         => __('column_action'),
            'column_name'           => __('column_name'),
	        'column_route'          => __('column_route'),
            'button_change'         => __('button_change'),
            'button_remove'         => __('button_remove'),
            'button_add'            => __('button_add'),
            'message_no'	        => __('message_no'),
            'confim_delete'         => __('confim_delete'),
            'button_status'          => __('button_status'),
        );
        
        //извлечение параметров запроса
        $sort = (string) $this->request->param('sort');
        $type = (string) $this->request->param('type');

        //установка значений для выборки из базы по-умолчанию
        if($sort == "") $sort = "name";
        if($type == "") $type = "asc";
     
        //извлекаем схемы
        $layouts = ORM::factory('Admin_Layout')
            ->order_by($sort, $type)
            ->find_all();
    
        //формируем значения для шаблона
        $content = View::factory($this->template_admin.'layouts/v_layouts_list')
            ->bind('template',$this->template_admin)
            ->bind('box_title',$this->template->page_title)
            ->bind('message', $this->message) 
            ->bind('errors', $this->errors)
            ->bind('layouts', $layouts)   
            ->bind('type', $type)
            ->bind('sort', $sort)
            ->bind('text', $text);
        
        // Вывод в шаблон
        $this->template->block_center = array($content);
    }
    
    //Удаление схем
    public function action_delete() {
        if(!$this->validateModify()){
    		$this->session->set('errors', __('error_permission'));	
    	}
    	else{
            //Извлечение данных
            $selected = $this->request->post("selected");    
            if(isset($selected)){ 
                //перебираем все схемы и удаляем
                foreach($selected as $id){
                    if($id != 0){ 
                        $layout = ORM::factory('Admin_Layout')->where('id', '=', $id)->find(); //извлекаем пользователя
                        $layout->delete();        //удаляем схему из базы  
                    }
                }
                $this->session->set('message', __('message_delete')); 
            }
        }
        $this->cache->delete('layouts');
        HTTP::redirect('admin/layouts');
    }
    
    //обновление схемы
    public function action_edit() {
        //если нажата кнопка сохранить
        if (isset($_POST['action']) && $_POST['action'] == "edit" && $this->validateModify())
        { 
            //Извлечение данных
            $this->data = Arr::extract($_POST, array('id', 'name', 'route', 'action'));
            
            //загрузка модели
            $layout = ORM::factory('Admin_Layout', $this->data['id']);
            $layout->values($this->data);
            
            //проверка на валидацию
            try {
                $layout->check();
            }
            catch(ORM_Validation_Exception $e)
            {
                $this->errors = $e->errors('admin/'.$this->language_folder);
            }
            
            //если все ок, то сохраняем
            if(empty($this->errors)){ 
                $layout->save();   //обновляем параметры 
                $this->session->set('message', __('message_edit'));
                $this->cache->delete('layouts');
                HTTP::redirect('admin/layouts'); 
            }  
        }

        //получаем контент
        $content = $this->getContent();
        
        // Вывод в шаблон
        $this->template->page_title .= __('heading_title_edit');
        $this->template->block_center = array($content);
    }
    
    //добавление схемы
    public function action_add() {
        
        //если нажата кнопка сохранить
        if (isset($_POST['action']) && $_POST['action'] == "add" && $this->validateModify())
        { 
            //Извлечение данных
            $this->data = Arr::extract($_POST, array('id', 'name', 'route', 'action'));

            //загрузка модели
            $layout = ORM::factory('Admin_Layout');
            $layout->values($this->data);
            
            //проверка на валидацию
            try {
                $layout->check();
            }
            catch(ORM_Validation_Exception $e)
            {
                $this->errors = $e->errors('admin/'.$this->language_folder);
            }
            
            //если все ок, то сохраняем
            if(empty($this->errors)){ 
                $layout->save();   //обновляем параметры 
                $this->session->set('message', __('message_add'));
                $this->cache->delete('layouts');
                HTTP::redirect('admin/layouts'); 
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

        $text = array(
            'text_name'             => __('text_name'),
            'text_route'            => __('text_route'),
            'button_save'   	    => __('button_save'),
            'button_abort'          => __('button_abort'),
        );
        
	    //если post пустой и существует id  
        if(empty($this->data) && $id)
        {
            //извлечение схемы
            $layout = ORM::factory('Admin_Layout', $id);

            if( ! $layout->loaded())
            {
                throw new HTTP_Exception_404('layout not found');
            }
           
            //формирование массива настроек
            $layout_arr = Array(
                "id"            => $layout->id,
                "name"          => $layout->name, 
                "route"         => $layout->route,
	            "action"        => 'edit',
            );

            //склеиваем 
            $this->data = $layout_arr;
        }
        
        //если post пустой, и не существует id
        if(empty($this->data) && !$id){ 
           $this->data = array(
               "action" => "add",
               "id" => 0,
               "name" => "",
               "route" => "",
           ); 
        }
        
        //формируем весь контент
        $content = View::factory($this->template_admin.'layouts/v_layouts_form')
                ->bind('template',$this->template_admin)
                ->bind('box_title',$this->template->page_title)
                ->bind('errors', $this->errors) //ошибки
                ->bind('text', $text) //массив текста для полей
                ->bind('data', $this->data);    //передаваемые данные
                          
        return $content;
    }  
    
    
}
