<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Languages extends Controller_Admin {

    public function before() {
        parent::before();

        //загрузка языкового файла
        i18n::lang('admin/'.$this->language_folder.'/languages');
       
        // Вывод в шаблон
        $this->template->page_title = __('heading_title');
        $this->template->page_url[] = HTML::anchor('admin/languages', $this->template->page_title);
    }
    
    //Вызывается по-умолчанию список языков
    public function action_index() {
        $this->message = $this->session->get("message");
        $this->session->set('message', null);
        $this->errors = $this->session->get("errors");
        $this->session->set('errors', null);
        
        //ссылки для кнопок
        $default = (int)$this->config->get("index_language_id");
        
        $text = Array(
            'column_action'         => __('column_action'),
            'column_status'         => __('column_status'),
            'column_sort_order'     => __('column_sort_order'),
            'column_code'           => __('column_code'),
            'column_title'          => __('column_title'),

            'button_change'         => __('button_change'),
            'button_remove'         => __('button_remove'),
            'button_add'            => __('button_add'),
            'button_status'          => __('button_status'),

            'message_no_languages'  => __('message_no_languages'),
            'confim_delete'         => __('confim_delete'),
            'text_default'          => __('text_default'),
        );
        
        
        //извлечение параметров запроса
        $status = $this->request->param('status');

        //установка значений для выборки из базы по-умолчанию
        if($status == "") $status = -1;

        //извлекаем новости
        $languages = DB::select()
            ->from('languages')   
            ->order_by('languages.sort_order', 'ASC')->execute()->as_array();
        
        
        //формируем значения для шаблона
        $content = View::factory($this->template_admin.'languages/v_languages_list')
            ->bind('template',$this->template_admin)
            ->bind('box_title',$this->template->page_title)
            ->bind('message', $this->message)
            ->bind('errors',  $this->errors)  
            ->bind('languages', $languages)    
            ->bind('default', $default)
            ->bind('text', $text);
        
        // Вывод в шаблон
        $this->template->block_center = array($content);
    }

    //Редактирование языка
    public function action_edit() {

        //если нажата кнопка сохранить
        if (isset($_POST['action']) && $_POST['action'] == "edit" && $this->validateModify())
        {
            //Извлечение данных
            $this->data = Arr::extract($_POST, array('name', 'status', 'sort_order', 'code', 'action', 'id', 'image','locale'));

            //загрузка модели языков
            $language = ORM::factory('Admin_Language', $this->data['id']);
            $language->values($this->data);
            
            //проверка на валидацию новости
            try {
                $language->check();
            }
            catch(ORM_Validation_Exception $e)
            {
                $this->errors = $e->errors('admin/'.$this->language_folder);
            }
            
            //если все ок, то сохраняем
            if(empty($this->errors)){ 
                $language->save();   //обновляем параметры языка
                $this->session->set('message', __('message_edit'));
                $this->cache->delete('languages');
                HTTP::redirect('admin/languages'); 
            }   
        }

        //получаем контент
        $content = $this->getContent();
        
        // Вывод в шаблон
        $this->template->page_title .= __('heading_title_edit');
        $this->template->block_center = array($content);
    }

    //Добавление языка
    public function action_add() {
        
        //если нажата кнопка сохранить
        if (isset($_POST['action']) && $_POST['action'] == "add" && $this->validateModify())
        {
            $this->errors = array();
            //Извлечение данных
            $this->data = Arr::extract($_POST, array('name', 'status', 'sort_order', 'code', 'action', 'id', 'image','locale'));
            
            //загружаем модель
            $language = ORM::factory('Admin_Language');
            $language->values($this->data);
            
            //проверяем на валидацию  язык
            try {
                $language->check();
            }
            catch(ORM_Validation_Exception $e)
            {
                $this->errors = $e->errors('admin/'.$this->language_folder);
            }
            
            //если все ок, то сохраняем
            if(empty($this->errors)){
                $language->save();
                $this->session->set('message', __('message_add'));
                $this->cache->delete('languages');
                HTTP::redirect('admin/languages');
            }      
        }

        $content = $this->getContent();
        
        // Вывод в шаблон
        $this->template->page_title .= __('heading_title_add');
        $this->template->block_center = array($content);
    }
 
    //Удаление языки
    public function action_delete() {
        if(!$this->validateModify()){
    		$this->session->set('errors', __('error_permission'));	
    	}
    	else{
            //Извлечение данных
            $selected = $this->request->post("selected");    
            if(isset($selected)){ 
                //перебираем все языки и удаляем
                foreach($selected as $id){
                    if($id != 0){ 
                        DB::delete('languages')->where('id', '=', $id)->execute();    
                    }
                }
                $this->session->set('message', __('message_delete'));
                
            }
        }
        $this->cache->delete('languages');
        HTTP::redirect('admin/languages');
    }

    //изменение статуса языка
    public function action_statusupdate(){
        if(!$this->validateModify()){
            $this->session->set('errors', __('error_permission'));	
    	}
    	else{
            $id = (int) $this->request->param('id');
            $status = (int) $this->request->param('status');
            
            if($status == 0 || $status == 1){
                $new = ORM::factory('Admin_Language', $id);
                
                if( ! $new->loaded())
                {
                        throw new HTTP_Exception_404('Status not found');
                }
    
                $new->status = $status;
                $new->save();
                $this->session->set('message', __('message_status'));
            }
        }
        $this->cache->delete('languages');
        HTTP::redirect('admin/languages');
    }
    
    //функция формирования данных для шаблона
    private function getContent(){

        $id = (int) $this->request->param('id');

        $text = array(
            'button_save'   	    => __('button_save'),
            'button_abort'          => __('button_abort'),

            'text_title'            => __('text_title'),
            'text_code'             => __('text_code'),
            'text_code_tooltip'     => __('text_code_tooltip'),
            'text_sort_order'       => __('text_sort_order'),
            'text_status'           => __('text_status'),
            'text_image'            => __('text_image'),
            'text_image_tooltip'    => __('text_image_tooltip'),
            'text_locale'           => __('text_locale'),
            'text_locale_tooltip'   => __('text_locale_tooltip'),
        );
        //если post пустой и существует id  
        if(empty($this->data) && $id)
        {
            //извлечение языка
            $language = ORM::factory('Admin_Language', $id);

            if( ! $language->loaded())
            {
                throw new HTTP_Exception_404('language not found');
            }

            //формирование массива настроек новостей
            
            $language_arr = Array(
                "id" => $language->id,
                "name" => $language->name, 
                "image" => $language->image, 
                "code" => $language->code,
                "locale" => $language->locale,
                "sort_order" => $language->sort_order,
                "status" => $language->status,
                "action" => 'edit',
            );

            //склеиваем два массива
            $this->data = $language_arr;
        }
        
        //если post пустой, и не существует id
        if(empty($this->data) && !$id){ 
           $this->data = array(
               "action" => "add",
               "id" => 0,
               "code" => "",
               "locale" => "",
               "image" => "",
               "name" => "",
               "sort_order" => "",
               "status" =>0
           ); 
        }
        
        //формируем весь контент
        $content = View::factory($this->template_admin.'languages/v_languages_form')
                ->bind('template',$this->template_admin)
                ->bind('box_title',$this->template->page_title)
                ->bind('errors', $this->errors) //ошибки
                ->bind('text', $text) //массив текста для полей
                ->bind('data', $this->data);    //передаваемые данные
        return $content;
    }
}