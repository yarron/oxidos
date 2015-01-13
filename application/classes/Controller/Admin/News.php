<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_News extends Controller_Admin {
     
    public function before() {
        parent::before();
        $this->template->styles[] = 'styles/admin/bower_components/font-awesome/css/font-awesome.min.css';
        $this->template->styles[] = 'styles/admin/bower_components/summernote/dist/summernote.css';

        $this->template->scripts[] = 'styles/admin/bower_components/summernote/dist/summernote.min.js';
        $this->template->scripts[] = 'styles/admin/bower_components/summernote/lang/summernote-ru-RU.js';
        $this->template->scripts[] = 'styles/admin/bower_components/summernote/plugin/summernote-ext-video.js';
        $this->template->scripts[] = 'styles/admin/bower_components/summernote/plugin/summernote-ext-fontstyle.js';
        $this->template->scripts[] = 'styles/'.$this->template_admin.'javascript/common.js';

        //загрузка языкового файла
        i18n::lang('admin/'.$this->language_folder.'/news');
       
        // Вывод в шаблон
        $this->template->page_title = __('heading_title');
        $this->template->page_url[] = HTML::anchor('admin/news', $this->template->page_title);
    }
    
    //Вызывается по-умолчанию список новостей
    public function action_index() {
        $this->message = $this->session->get("message");
        $this->session->set('message', null);
        $this->errors = $this->session->get("errors");
        $this->session->set('errors', null);

        $text = Array(
            'column_action'         => __('column_action'),
            'column_status'         => __('column_status'),
            'column_sort_order'     => __('column_sort_order'),
            'column_date_modified'  => __('column_date_modified'),
            'column_alias'          => __('column_alias'),
            'column_title'          => __('column_title'),

            'message_no_news'       => __('message_no_news'),
            'confim_delete'         => __('confim_delete'),

            'button_change'         => __('button_change'),
            'button_remove'         => __('button_remove'),
            'button_add'            => __('button_add'),
            'button_status'          => __('button_status'),
        );
        
        
        //извлечение параметров запроса
        $page = $this->request->param('page');
        $status = $this->request->param('status');
        $sort = (string) $this->request->param('sort');
        $type = (string) $this->request->param('type');

        if($sort == "title") $table = 'newsdescriptions.';
        else $table = 'news.';
        
        //установка значений для выборки из базы по-умолчанию
        if($page == "") $page = 1;
        if($status == "") $status = -1;
        if($sort == "") $sort = "id";
        if($type == "") $type = "desc";
        
        //извлекаем количество новостей  
        $count = ORM::factory('Admin_New')->count_all();
        i18n::lang('admin/'.$this->language_folder.'/common');
        //высчитываем пагинацию
        $pagination = Pagination::factory(array( 'total_items' => $count ,'view'=>'pagination/admin'))
                ->route_params( array( 
                    'controller' => Request::current()->controller(), 
                    'action' => Request::current()->action(),
                  ));
        
        //извлекаем новости
        $news = DB::select()
            ->from('news')   
            ->where('language_id', '=', $this->language_id)
            ->join('newsdescriptions')->on('news.id', '=', 'newsdescriptions.new_id')
            ->limit($pagination->items_per_page)->offset($pagination->offset)
            ->order_by($table.$sort, $type)->execute()->as_array();
        
        
        //формируем значения для шаблона
        $content = View::factory($this->template_admin.'news/v_news_list')
            ->bind('template',$this->template_admin)
            ->bind('box_title',$this->template->page_title)
            ->bind('message', $this->message)
            ->bind('errors',  $this->errors)        
            ->bind('pagination', $pagination)
            ->bind('news', $news)
            ->bind('sort', $sort)
            ->bind('type', $type)
            ->bind('page', $page)
            ->bind('text', $text);
        
        // Вывод в шаблон
        $this->template->block_center = array($content);
    }

    //Редактирование новости
    public function action_edit() {
        $this->message = $this->session->get("message");
        $this->session->set('message', null);
        $this->errors = $this->session->get("errors");
        $this->session->set('errors', null);

        //если нажата кнопка сохранить
        if (isset($_POST['action']) && $_POST['action'] == "edit" && $this->validateModify())
        { 
            //Извлечение данных
            $this->data = Arr::extract($_POST, array('image','alias', 'status', 'sort_order', 'new_description', 'action', 'id', 'button'));
            $this->data['alias'] = $this->translateAlias($this->data['alias']);
            
            //загрузка модели новостей
            $new = ORM::factory('Admin_New', $this->data['id']);
            $new->date_modified = time();
            $new->values($this->data);
            
            //проверка на валидацию новости
            try {
                $new->check();
            }
            catch(ORM_Validation_Exception $e)
            {
                $this->errors = $e->errors('admin/'.$this->language_folder);
            }
            
            //проверка на валидацию описания новости
            foreach ($this->data['new_description'] as $k=>$value) {
                //извлекаем статью
                $descriptions = ORM::factory('Admin_Newsdescription')->where('new_id', '=', $this->data['id'])->and_where('language_id', '=', $k)
                        ->find();
                $descriptions->values($this->data['new_description'][$k]);
                try {
                    $descriptions->check();
                }
                catch (ORM_Validation_Exception $e) {
                    $this->errors = $e->errors('admin/'.$this->language_folder);
                }                 
            }
            
            //если все ок, то сохраняем
            if(empty($this->errors)){ 
                $new->save();   //обновляем параметры новости
                
                //сохранение мультиязычного описания новости
                foreach ($this->data['new_description'] as $k=>$value) {
                    //извлекаем новость
                    $descriptions = ORM::factory('Admin_Newsdescription')->where('new_id', '=', $this->data['id'])->and_where('language_id', '=', $k)
                            ->find();

                    //обновляем её
                    $descriptions->values($this->data['new_description'][$k])
                            ->update();
                }
                $this->session->set('message', __('message_edit'));
                $this->cache->delete('wnews');

                if($this->data['button'] == 'apply')
                    HTTP::redirect('admin/news/edit/'.$this->data['id']);
                else
                    HTTP::redirect('admin/news');

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
        $this->message = $this->session->get("message");
        $this->session->set('message', null);
        $this->errors = $this->session->get("errors");
        $this->session->set('errors', null);

        //если нажата кнопка сохранить
        if (isset($_POST['action']) && $_POST['action'] == "add" && $this->validateModify())
        {
            $this->errors = array();
            //Извлечение данных
            $this->data = Arr::extract($_POST, array('image','alias', 'status', 'sort_order', 'new_description','action', 'id','button'));
            $this->data['alias'] = $this->translateAlias($this->data['alias']);
            
            //загружаем модель
            $new = ORM::factory('Admin_New');
            $new->date_modified = time();
            $new->values($this->data);
            
            //проверяем на валидацию статью
            try {
                $new->check();
            }
            catch(ORM_Validation_Exception $e)
            {
                $this->errors = $e->errors('admin/'.$this->language_folder);
            }
            
            //проверяем на валидацию описание статьи
            foreach ($this->data['new_description'] as $k=>$value) {
                $descriptions = ORM::factory('Admin_Newsdescription');
                $descriptions->values($this->data['new_description'][$k]);
                try {
                    $descriptions->check();
                }
                catch (ORM_Validation_Exception $e) {
                    $this->errors = $e->errors('admin/'.$this->language_folder);
                }  
            }
            
            //если все ок, то сохраняем
            if(empty($this->errors)){
                $new->save();

                //сохранение мультиязычного описания новости
                foreach ($this->data['new_description'] as $k=>$value) {
                    $descriptions = ORM::factory('Admin_Newsdescription');
                    $descriptions->new_id = $new->pk();
                    $descriptions->language_id = $k;
                    $descriptions->values($this->data['new_description'][$k]);
                    $descriptions->save(); 
                }
                $this->session->set('message', __('message_add'));
                $this->cache->delete('wnews');

                if($this->data['button'] == 'apply')
                    HTTP::redirect('admin/news/edit/'.$new->pk());
                else
                    HTTP::redirect('admin/news');
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
                //перебираем все статьи и удаляем
                foreach($selected as $id){
                    if($id != 0){ 
                        DB::delete('newsdescriptions')->where('new_id', '=', $id)->execute();
                        DB::delete('news')->where('id', '=', $id)->execute();    
                    }
                }
                $this->session->set('message', __('message_delete'));
                $this->cache->delete('wnews');
            }
        }
        
        HTTP::redirect('admin/news');
    }

    //изменение статуса новости
    public function action_statusupdate(){
        if(!$this->validateModify()){
            $this->session->set('errors', __('error_permission'));	
    	}
    	else{
            $id = (int) $this->request->param('id');
            $status = (int) $this->request->param('status');
            
            if($status == 0 || $status == 1){
                $new = ORM::factory('Admin_New', $id);
                
                if( ! $new->loaded())
                {
                        throw new HTTP_Exception_404('Status not found');
                }
    
                $new->status = $status;
                $new->save();
                $this->session->set('message', __('message_status'));
                $this->cache->delete('wnews');
            }
        }
        
        HTTP::redirect('admin/news');
    }
    
    //функция формирования данных для шаблона
    private function getContent(){
        $id = (int) $this->request->param('id');
        $page = $this->request->param('page');
        if($page == "") $page = 1;

        $languages = ORM::factory('Admin_Language')->order_by('sort_order','ASC')->find_all();
        $text = array(
            'tab-general'           => __('tab-general'),
            'tab-data'              => __('tab-data'),

            'text_title'            => __('text_title'),
            'text_alias'            => __('text_alias'),
            'text_alias_tooltip'    => __('text_alias_tooltip'),
            'text_sort_order'       => __('text_sort_order'),
            'text_status'           => __('text_status'),
            'text_seo_title'        => __('text_seo_title'),
            'text_meta_description' => __('text_meta_description'),
            'text_meta_keywords'    => __('text_meta_keywords'),
            'text_description'      => __('text_description'),
            'text_image'            => __('text_image'),
            'text_browse'           => __('text_browse'),
            'text_clear'            => __('text_clear'),
            'text_image_manager'    => __('text_image_manager'),

            'button_loading'   	    => __('button_loading'),
            'button_preview'        => __('button_preview'),
            'button_save'   	    => __('button_save'),
            'button_abort'          => __('button_abort'),
            'button_apply'          => __('button_apply'),
        );
        //если post пустой и существует id  
        if(empty($this->data) && $id)
        {
            //извлечение описания
            $data = ORM::factory('Admin_Newsdescription')->where('new_id', '=', $id)->find_all();

            //формируем массив из описаний мультиязычный
            foreach ($languages as $language){
                foreach ($data as $desc){
                    if($language->id == $desc->language_id){
                        $new_description[$language->id] = Array(
                            'seo_title' => $desc->seo_title,
                            'meta_description' => $desc->meta_description,
                            'meta_keywords' => $desc->meta_keywords,
                            'title' => $desc->title,
                            'description' => $desc->description,
                        );    
                    }
                }
            }

            //извлечение настроек новостей
            $new_obj = ORM::factory('Admin_New', $id);

            if( ! $new_obj->loaded())
            {
                throw new HTTP_Exception_404('news not found');
            }

            //формирование массива настроек статей
            if ($new_obj->image && file_exists(DIR_IMAGE . $new_obj->image)) {
                $image = $new_obj->image;
            } else {
                $image = 'no_image.jpg';
            }
            
            //формирование массива настроек новостей
            
            $new_arr = Array(
                "id" => $new_obj->id,
                "alias" => $new_obj->alias,
                "sort_order" => $new_obj->sort_order,
                "status" => $new_obj->status,
                "image"         => $image,
                "thumb"         => $this->resizer($image, 100, 100),
                "no_image"      => $this->resizer('no_image.jpg', 100, 100),
                "action" => 'edit',
            );

            $new = array(
                "new_description" => $new_description,
            );
            //склеиваем два массива
            $this->data = array_merge($new, $new_arr);
        
        }
        
        //если post пустой, и не существует id
        if(empty($this->data) && !$id){ 
           $this->data = array(
               "action" => "add",
               "id" => 0,
               "alias" => "",
               "sort_order" => "",
               "image"         => 'no_image.jpg',
               "thumb"         => $this->resizer('no_image.jpg', 100, 100),
               "no_image"      => $this->resizer('no_image.jpg', 100, 100),
               "status" =>0
           ); 
        }
        
        //если post не пустой
        if(!empty($this->data)){
           $this->data["thumb"] = $this->data['image'] ? $this->resizer($this->data['image'], 100, 100) : $this->resizer('no_image.jpg', 100, 100);
           $this->data["no_image"] = $this->resizer('no_image.jpg', 100, 100);
        }
        
        //формируем весь контент
        $content = View::factory($this->template_admin.'news/v_news_form')
                ->bind('template',$this->template_admin)
                ->bind('box_title',$this->template->page_title)
                ->bind('message', $this->message)
                ->bind('errors', $this->errors)
                ->bind('languages', $languages)
                ->bind('locale', $this->language_folder)
                ->bind('text', $text)
                ->bind('page', $page)
                ->bind('data', $this->data);
                          
        return $content;
    }

}
