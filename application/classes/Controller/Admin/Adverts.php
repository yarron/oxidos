<?php defined('SYSPATH') or die('No direct script access.');
/*
 * реклама
 */
class Controller_Admin_Adverts extends Controller_Admin {
    
    public function before() {
        parent::before();

        //загрузка языкового файла
        i18n::lang('admin/'.$this->language_folder.'/adverts');
        $this->template->scripts[] = 'styles/'.$this->template_admin.'javascript/common.js';

        // Вывод в шаблон
        $this->template->page_title = __('heading_title');
        $this->template->page_url[] = HTML::anchor('admin/adverts', $this->template->page_title);
    }

    public function action_index() {
        $this->message = $this->session->get("message");
        $this->session->set('message', null);
        $this->errors = $this->session->get("errors");
        $this->session->set('errors', null);
        

        $text = Array(
            'column_action'         => __('column_action'),
            'column_name'           => __('column_name'),
	        'column_status'         => __('column_status'),

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
        $adverts = ORM::factory('Admin_Advert')
            ->order_by($sort, $type)
            ->find_all();
    
        //формируем значения для шаблона
        $content = View::factory($this->template_admin.'adverts/v_adverts_list')
            ->bind('template',$this->template_admin)
            ->bind('box_title',$this->template->page_title)
            ->bind('message', $this->message) 
            ->bind('errors', $this->errors)
            ->bind('adverts', $adverts)
            ->bind('sort', $sort)
            ->bind('type', $type)
            ->bind('text', $text);
        
        // Вывод в шаблон
        $this->template->block_center = array($content);
    }
    
    //изменение статуса рекламы
    public function action_statusupdate(){
        if(!$this->validateModify()){
    		$this->session->set('errors', __('error_permission'));	
    	}
    	else{
            $id = (int) $this->request->param('id');
            $status = (int) $this->request->param('status');
            if($status == 0 || $status == 1){
                $advert = ORM::factory('Admin_Advert', $id);
                
                if( ! $advert->loaded())
                {
                        throw new HTTP_Exception_404('Status not found');
                }
    
                $advert->status = $status;
                $advert->save();
                $this->cache->delete('wslider');
                $this->session->set('message', __('message_status'));
            }
        }
        HTTP::redirect('admin/adverts');
    }
    
    //Удаление рекламы
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
                        $advert = ORM::factory('Admin_Advert')->where('id', '=', $id)->find(); //извлекаем рекламу
                        $advert->delete();        //удаляем рекламу из базы 
                        
                        $descriptions = ORM::factory('Admin_Advertsdescription')->where('advert_id', '=', $id)->find_all(); //извлекаем рекламу
                        foreach($descriptions as $ds)
                        {
                        	$ds->delete(); //удаляем описание рекламы из базы 
                        }
                        
                        $images = ORM::factory('Admin_Advertsimage')->where('advert_id', '=', $id)->find_all(); //извлекаем рекламу
                        foreach($images as $im)
                        {
                        	$im->delete(); //удаляем картинки рекламы из базы 
                        }
                         
                    }
                }
                $this->cache->delete('wslider');
                $this->session->set('message', __('message_delete')); 
            }
        }
        HTTP::redirect('admin/adverts');
    }
    
    //обновление рекламы
    public function action_edit() {
        //если нажата кнопка сохранить
        if (isset($_POST['action']) && $_POST['action'] == "edit" && $this->validateModify())
        { 
            $languages = ORM::factory('Admin_Language')->order_by('sort_order','ASC')->find_all();
            //print_r($_POST); die();
            //Извлечение данных
            $this->data = Arr::extract($_POST, array('id', 'name', 'status', 'action', 'advert_images','image'));
            
            //загрузка модели рекламы
            $advert = ORM::factory('Admin_Advert', $this->data['id']);
            $advert->values($this->data);

            //проверка на валидацию
            try {
                $advert->check();
            }
            catch(ORM_Validation_Exception $e)
            {
                $this->errors = $e->errors('admin/'.$this->language_folder);
            }
            //проверяем на валидацию описание 
            foreach ($this->data['advert_images'] ? $this->data['advert_images'] : array() as $k=>$value) {
                
                foreach ($languages as $language) {
                    $descriptions = ORM::factory('Admin_Advertsdescription');
                    
                    $descriptions->values($this->data['advert_images'][$k]['descriptions'][$language->id]);
                    
                    try {
                        $descriptions->check();
                    }
                    catch (ORM_Validation_Exception $e) {
                        $this->errors = $e->errors('admin/'.$this->language_folder);
                    }
                }   
            }
            //если все ок, то сохраняем
            if(empty($this->errors)){ 
                $advert->save();   //обновляем параметры 
                
                //удаление всех изображений данной рекламы, чтобы потом сохнанить новые
                $images = ORM::factory('Admin_Advertsimage')->where('advert_id', '=', $this->data['id'])->find_all();
                foreach($images as $im)
                {
                	$im->delete();
                }
                
                //удаление всех описаний данной рекламы, чтобы потом сохнанить новые
                $descriptions = ORM::factory('Admin_Advertsdescription')->where('advert_id', '=', $this->data['id'])->find_all();
                foreach($descriptions as $ds)
                {
                	$ds->delete();
                }
                
                //сохранение мультиязычного описания 
                foreach ($this->data['advert_images'] ? $this->data['advert_images'] : array() as $k=>$value) {
                    
                    //сохранение нового изображения и ссылки
                    $image = ORM::factory('Admin_Advertsimage');
                    $image->advert_id = $this->data['id'];
                    $image->link = $value['link'];
                    $image->sort_order = $value['sort_order'];
                    $image->image = $value['image'];
                    $image->save();
                    
                    foreach ($languages as $language) {
                        //сохнанение описания рекламы
                        $description = ORM::factory('Admin_Advertsdescription');
                        $description->image_id = $image->pk();
                        $description->advert_id = $this->data['id'];
                        $description->language_id = $language->id;
                        $description->title = $this->data['advert_images'][$k]['descriptions'][$language->id]['title'];
                        $description->save();
                    }
                }
                $this->session->set('message', __('message_edit'));
                $this->cache->delete('wslider');
                HTTP::redirect('admin/adverts'); 
            }  
        }

        //получаем контент
        $content = $this->getContent();
        
        // Вывод в шаблон
        $this->template->page_title .= __('heading_title_edit');
        $this->template->block_center = array($content);
    }
    
    //добавление рекламы
    public function action_add() {
        
        //если нажата кнопка сохранить
        if (isset($_POST['action']) && $_POST['action'] == "add" && $this->validateModify())
        { 
            $languages = ORM::factory('Admin_Language')->order_by('sort_order','ASC')->find_all();
            
            //Извлечение данных
            $this->data = Arr::extract($_POST, array('id', 'name', 'status', 'action', 'advert_images','image'));
            
            //загрузка модели рекламы
            $advert = ORM::factory('Admin_Advert');
            $advert->values($this->data);

            //проверка на валидацию
            try {
                $advert->check();
            }
            catch(ORM_Validation_Exception $e)
            {
                $this->errors = $e->errors('admin/'.$this->language_folder);
            }
            
            //проверяем на валидацию описание 
            foreach ($this->data['advert_images'] ? $this->data['advert_images'] : array() as $k=>$value) {
                
                foreach ($languages as $language) {
                    $descriptions = ORM::factory('Admin_Advertsdescription');
                    
                    $descriptions->values($this->data['advert_images'][$k]['descriptions'][$language->id]);
                    
                    try {
                        $descriptions->check();
                    }
                    catch (ORM_Validation_Exception $e) {
                        $this->errors = $e->errors('admin/'.$this->language_folder);
                    }
                }   
            }
            
            
            //если все ок, то сохраняем
            if(empty($this->errors)){ 
                $advert->save();   //обновляем параметры 
                
                //сохранение мультиязычного описания 
                foreach ($this->data['advert_images'] ? $this->data['advert_images'] : array() as $k=>$value) {
                    
                    //сохранение нового изображения и ссылки
                    $image = ORM::factory('Admin_Advertsimage');
                    $image->advert_id = $advert->pk();
                    $image->link = $value['link'];
                    $image->sort_order = $value['sort_order'];
                    $image->image = $value['image'];
                    $image->save();
                    
                    foreach ($languages as $language) {
                        //сохнанение описания рекламы
                        $description = ORM::factory('Admin_Advertsdescription');
                        $description->image_id = $image->pk();
                        $description->advert_id = $advert->pk();
                        $description->language_id = $language->id;
                        $description->title = $this->data['advert_images'][$k]['descriptions'][$language->id]['title'];
                        $description->save();
                    }
                }
                $this->session->set('message', __('message_add'));
                $this->cache->delete('wslider');
                HTTP::redirect('admin/adverts'); 
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
        
        $languages = ORM::factory('Admin_Language')->order_by('sort_order','ASC')->find_all();
        
        $text = array(
            'entry_name'            => __('entry_name'),
	        'entry_title'           => __('entry_title'),
            'entry_link'            => __('entry_link'),
	        'entry_image'           => __('entry_image'),
            'entry_status'          => __('entry_status'),
            'entry_sort_order'      => __('entry_sort_order'),
            
            'text_browse'           => __('text_browse'),
            'text_clear'            => __('text_clear'),
            'text_image_manager'    => __('text_image_manager'),
            
            'button_add'            => __('button_add'),
            'button_remove'         => __('button_remove'),
            'button_loading'   	    => __('button_loading'),
            'button_save'   	    => __('button_save'),
            'button_abort'          => __('button_abort'),
        );
        
	    //если post пустой и существует id  
        if(empty($this->data) && $id)
        {
            //извлечение изображений
            $images = ORM::factory('Admin_Advertsimage')->where('advert_id', '=', $id)->order_by('sort_order','ASC')->order_by('id','ASC')->find_all();
            
            //извлечение описания
            $descriptions = ORM::factory('Admin_Advertsdescription')->where('advert_id', '=', $id)->find_all();
            
            $advert_images = array();
            $advert_descriptions = array();
            
            foreach ($images as $advert_image){
                foreach ($languages as $language){
                    foreach ($descriptions as $desc){
                        if($language->id == $desc->language_id && $advert_image->advert_id == $desc->advert_id && $advert_image->id == $desc->image_id){
                            $advert_descriptions[$language->id] = Array(
                                'title' => $desc->title,
                            );    
                        }
                    }
                }
                if ($advert_image->image && file_exists(DIR_IMAGE . $advert_image->image)) {
    				$image = $advert_image->image;
    			} else {
    				$image = 'no_image.jpg';
    			}
                
                $advert_images[] = Array(
                    'link'          => $advert_image->link,
                    'sort_order'    => $advert_image->sort_order,
                    'image'         => $image,
                    'thumb'         => $this->resizer($image, 150, 100),
                    'descriptions'  => $advert_descriptions,
                );    
            }
                
            //извлечение рекламы
            $advert_obj = ORM::factory('Admin_Advert', $id);

            if( ! $advert_obj->loaded())
            {
                throw new HTTP_Exception_404('layout not found');
            }
           
            //формирование массива настроек
            $this->data = Array(
                "advert_images" => $advert_images,
                "id"            => $advert_obj->id,
                "name"          => $advert_obj->name, 
                "status"        => $advert_obj->status,
                "no_image"      => $this->resizer('no_image.jpg', 150, 100),
	            "action"        => 'edit',
            );
        }
        
        
        //если post пустой, и не существует id
        if(empty($this->data) && !$id){ 
           $this->data = array(
               "action"         => "add",
               "id"             => 0,
               "name"           => "",
               "status"         => "",
               "advert_images"  => array(),
               "no_image"       => $this->resizer('no_image.jpg', 150, 100),
           ); 
        }
        
        //если post не пустой
        if(!empty($this->data)){
            if($this->data['advert_images']){
                foreach($this->data['advert_images'] as $k => $value){
                    $this->data['advert_images'][$k] = array(
                        'link'          => $value['link'],
                        'sort_order'    => $value['sort_order'],
                        'image'         => $value['image'],
                        'thumb'         => $value['image'] ? $this->resizer($value['image'], 150, 100) : $this->resizer('no_image.jpg', 150, 100),
                        'descriptions'  => $value['descriptions'],
                    );
                }
            }else $this->data['advert_images'] = array();
           $this->data["no_image"] = $this->resizer('no_image.jpg', 150, 100);
           
        }
        
        //формируем весь контент
        $content = View::factory($this->template_admin.'adverts/v_adverts_form')
                ->bind('template',$this->template_admin)
                ->bind('box_title',$this->template->page_title)
                ->bind('languages', $languages) //языки
                ->bind('errors', $this->errors) //ошибки
                ->bind('text', $text) //массив текста для полей
                ->bind('data', $this->data);    //передаваемые данные
                          
        return $content;
    }  
    
    
}
