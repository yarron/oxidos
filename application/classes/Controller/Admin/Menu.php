<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Menu extends Controller_Admin {
   public function before() {
        parent::before();
        $this->template->styles[] = 'styles/admin/bower_components/jquery-ui/themes/south-street/jquery-ui.min.css';
        $this->template->scripts[] = 'styles/admin/bower_components/jquery-ui/ui/minified/core.min.js';
        $this->template->scripts[] = 'styles/admin/bower_components/jquery-ui/ui/minified/effect.min.js';
        $this->template->scripts[] = 'styles/admin/bower_components/jquery-ui/ui/minified/effect-slide.min.js';

        //загрузка языкового файла
        i18n::lang('admin/'.$this->language_folder.'/menu');
       
        // Вывод в шаблон
        $this->template->page_title = __('heading_title');
        $this->template->page_url[] = HTML::anchor('admin/menu', $this->template->page_title);
    }

    //Вызывается по-умолчанию список 
    public function action_index() {
        $this->message = $this->session->get("message");
        $this->session->set('message', null);
        $this->errors = $this->session->get("errors");
        $this->session->set('errors', null);

        $text = Array(
            'column_action'         => __('column_action'),
            'column_status'         => __('column_status'),
            'column_title'          => __('column_title'),
            'column_alias'          => __('column_alias'),
            'column_sort_order'     => __('column_sort_order'),
            'button_change'         => __('button_change'),
            'message_no'            => __('message_no'),

            'confim_delete'         => __('confim_delete'),

            'button_change'         => __('button_change'),
            'button_remove'         => __('button_remove'),
            'button_add'            => __('button_add'),
            'button_status'         => __('button_status'),
        );
        
        
        //извлечение параметров запроса
        $status = $this->request->param('status');
        $sort = (string) $this->request->param('sort');
        $type = (string) $this->request->param('type');

        if($sort == "title") $table = 'menudescriptions.';
        else $table = 'menu.';
        
        //установка значений для выборки из базы по-умолчанию
        if($status == "") $status = -1;
        if($sort == "") $sort = "sort_order";
        if($type == "") $type = "ASC";
 
        //извлекаем страницы
        $menu = DB::select()
            ->from('menu')   
            ->where('menudescriptions.language_id', '=', $this->language_id)
            ->join('menudescriptions')->on('menu.id', '=', 'menudescriptions.menu_id')
            ->order_by($table.$sort, $type)
            ->execute()->as_array();
        
        
        //формируем значения для шаблона
        $content = View::factory($this->template_admin.'menu/v_menu_list')
            ->bind('template',$this->template_admin)
            ->bind('box_title',$this->template->page_title)
            ->bind('message', $this->message)
            ->bind('errors',  $this->errors)        
            ->bind('menu', $menu)
            ->bind('sort', $sort)
            ->bind('text', $text)
            ->bind('type', $type);

        // Вывод в шаблон
        $this->template->block_center = array($content);
    }

    //Редактирование статической страницы
    public function action_edit() {

        //если нажата кнопка сохранить
        if (isset($_POST['action']) && $_POST['action'] == "edit" && $this->validateModify())
        {
            //Извлечение данных
            $this->data = Arr::extract($_POST, array('menu_description', 'page_mode', 'url', 'sort_order', 'status', 'action', 'id','page_id'));
           
            //загрузка модели 
            $menu = ORM::factory('Admin_Menu', $this->data['id']);
            $menu->values($this->data);

            //проверка на валидацию новости
            try {
                $menu->check();
            }
            catch(ORM_Validation_Exception $e)
            {
                $this->errors = $e->errors('admin/'.$this->language_folder);
            }
            
            //проверка на валидацию описания 
            foreach ($this->data['menu_description'] as $k=>$value) {
                //извлекаем статью
                $descriptions = ORM::factory('Admin_Menudescription')->where('menu_id', '=', $this->data['id'])->and_where('language_id', '=', $k)
                        ->find();
                $descriptions->values($this->data['menu_description'][$k]);
                try {
                    $descriptions->check();
                }
                catch (ORM_Validation_Exception $e) {
                    $this->errors = $e->errors('admin/'.$this->language_folder);
                }                 
            }
            
            //если все ок, то сохраняем
            if(empty($this->errors)){ 
                $menu->save();   //обновляем параметры 
                
                //сохранение мультиязычного описания 
                foreach ($this->data['menu_description'] as $k=>$value) {
                    //извлекаем 
                    $descriptions = ORM::factory('Admin_Menudescription')->where('menu_id', '=', $this->data['id'])->and_where('language_id', '=', $k)
                            ->find();

                    //обновляем её
                    $descriptions->values($this->data['menu_description'][$k])
                            ->update();
                }
                $this->session->set('message', __('message_edit'));
                $this->cache->delete('menu');
                HTTP::redirect('admin/menu'); 
                
            }   
        }

        //получаем контент
        $content = $this->getContent();
        
        // Вывод в шаблон
        $this->template->page_title .= __('heading_title_edit');
        $this->template->block_center = array($content);
    }

    //Добавление новости
    public function action_add() {
        
        //если нажата кнопка сохранить
        if (isset($_POST['action']) && $_POST['action'] == "add" && $this->validateModify())
        {
            $this->errors = array();
            //Извлечение данных
            $this->data = Arr::extract($_POST, array('menu_description', 'page_mode', 'url', 'sort_order', 'status', 'action', 'id','page_id'));

            //загружаем модель
            $menu = ORM::factory('Admin_Menu');
            $menu->values($this->data);
            
            //проверяем на валидацию статью
            try {
                $menu->check();
            }
            catch(ORM_Validation_Exception $e)
            {
                $this->errors = $e->errors('admin/'.$this->language_folder);
            }
            
            //проверяем на валидацию описание статьи
            foreach ($this->data['menu_description'] as $k=>$value) {
                $descriptions = ORM::factory('Admin_Menudescription');
                $descriptions->values($this->data['menu_description'][$k]);
                try {
                    $descriptions->check();
                }
                catch (ORM_Validation_Exception $e) {
                    $this->errors = $e->errors('admin/'.$this->language_folder);
                }  
            }
            
            //если все ок, то сохраняем
            if(empty($this->errors)){
                $menu->save();

                //сохранение мультиязычного описания новости
                foreach ($this->data['menu_description'] as $k=>$value) {
                    $descriptions = ORM::factory('Admin_Menudescription');
                    $descriptions->menu_id = $menu->pk();
                    $descriptions->language_id = $k;
                    $descriptions->values($this->data['menu_description'][$k]);
                    $descriptions->save(); 
                }
                $this->session->set('message', __('message_edit'));
                $this->cache->delete('menu');
                HTTP::redirect('admin/menu');
            }      
        }

        $content = $this->getContent();
        
        // Вывод в шаблон
        $this->template->page_title .= __('heading_title_add');
        $this->template->block_center = array($content);
    }
 
    //Удаление новости
    public function action_delete() {
        if(!$this->validateModify()){
    		$this->session->set('errors', __('error_permission'));	
    	}
    	else{
            //Извлечение данных
            $selected = $this->request->post("selected");    
            if(isset($selected)){ 
                
                foreach($selected as $id){
                    if($id != 0){ 
                        DB::delete('menudescriptions')->where('menu_id', '=', $id)->execute();
                        DB::delete('menu')->where('id', '=', $id)->execute();    
                    }
                }
                $this->session->set('message', __('message_delete'));
                $this->cache->delete('menu');
            }
        }
        HTTP::redirect('admin/menu');
    }

    //изменение статуса статьи
    public function action_statusupdate(){
        if(!$this->validateModify()){
            $this->session->set('errors', __('error_permission'));	
    	}
    	else{
            $id = (int) $this->request->param('id');
            $status = (int) $this->request->param('status');
            
            if($status == 0 || $status == 1){
                $menu = ORM::factory('Admin_Menu', $id);
                
                if( ! $menu->loaded())
                {
                        throw new HTTP_Exception_404('Status not found');
                }
    
                $menu->status = $status;
                $menu->save();
                $this->session->set('message', __('message_status'));
                $this->cache->delete('menu');
            }
        }
        
        HTTP::redirect('admin/menu');
    }
    
    //функция формирования данных для шаблона
    private function getContent(){

        $id = (int) $this->request->param('id');

        $languages = ORM::factory('Admin_Language')->order_by('sort_order','ASC')->find_all();
        $text = array(
            'text_title'            => __('text_title'),
            'text_url'              => __('text_url'),
            'text_sort_order'       => __('text_sort_order'),
            'text_status'           => __('text_status'),
            'text_page_static'      => __('text_page_static'),
            'text_page_other'       => __('text_page_other'),
            'button_save'   	    => __('button_save'),
            'button_abort'          => __('button_abort'),
            'button_apply'          => __('button_apply'),
        );
        
        $pages_arr = DB::select('pagesdescriptions.title','pages.id')
            ->from('pages')   
            ->where('pagesdescriptions.language_id', '=', $this->language_id)
            ->and_where('pages.status', '=', 1)
            ->join('pagesdescriptions')->on('pages.id', '=', 'pagesdescriptions.page_id')
            ->order_by('pagesdescriptions.title', 'ASC')
            ->execute()->as_array();
        
        $pages = array();
        foreach ($pages_arr as $page){
            $pages[$page['id']] = $page['title'];
        }
        
        //если post пустой и существует id  
        if(empty($this->data) && $id)
        {
            //извлечение описания
            $data = ORM::factory('Admin_Menudescription')->where('menu_id', '=', $id)->find_all();

            //формируем массив из описаний мультиязычный
            foreach ($languages as $language){
                foreach ($data as $desc){
                    if($language->id == $desc->language_id){
                        $menu_description[$language->id] = Array(
                            'title' => $desc->title,
                        );    
                    }
                }
            }

            //извлечение настроек новостей
            $menu_obj = ORM::factory('Admin_Menu', $id);

            if( ! $menu_obj->loaded())
            {
                throw new HTTP_Exception_404('menu not found');
            }

            //формирование массива настроек новостей
            
            $menu_arr = Array(
                "action"            => 'edit',
                "id"                => $menu_obj->id,
                "url"               => $menu_obj->url,
                "sort_order"        => $menu_obj->sort_order,
                "status"            => $menu_obj->status,
                "page_id"           => $menu_obj->page_id,
                "menu_description"  => $menu_description,
            );

            $this->data = $menu_arr;
        }
        
        //если post пустой, и не существует id
        if(empty($this->data) && !$id){ 
           $this->data = array(
               "action"             => "add",
               "id"                 => 0,
               "url"                => "",
               "sort_order"         => "",
               "status"             => 0,
               "page_id"            => 0,
               "menu_description"   => array(),
           ); 
        }
        
        //формируем весь контент
        $content = View::factory($this->template_admin.'menu/v_menu_form')
                ->bind('template',$this->template_admin)
                ->bind('box_title',$this->template->page_title)
                ->bind('errors', $this->errors) //ошибки
                ->bind('languages', $languages) //массив языков
                ->bind('text', $text) //массив текста для полей
                ->bind('pages', $pages) 
                ->bind('data', $this->data);    //передаваемые данные
                          
        return $content;
    }

}