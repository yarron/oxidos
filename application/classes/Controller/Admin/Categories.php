<?php defined('SYSPATH') or die('No direct script access.');
/*
 * Категории
 */
class Controller_Admin_Categories extends Controller_Admin {

    private $path = array();
    
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
        i18n::lang('admin/'.$this->language_folder.'/categories');

        // Вывод в шаблон
        $this->template->page_title = __('heading_title');
        $this->template->page_url[] = HTML::anchor('admin/categories', $this->template->page_title);
    }

    //Вызывается по-умолчанию список категорий
    public function action_index() {
        $this->message = $this->session->get("message");
        $this->session->set('message', null);
        $this->errors = $this->session->get("errors");
        $this->session->set('errors', null);
        
        //ссылки для кнопок

        $text = Array(
            'column_action'         => __('column_action'),
            'column_status'         => __('column_status'),
            'column_sort_order'     => __('column_sort_order'),
            'column_date_modified'  => __('column_date_modified'),
            'column_alias'          => __('column_alias'),
            'column_title'          => __('column_title'),
            'column_children'       => __('column_children'),
            'message_no'            => __('message_no'),
            'confim_delete'         => __('confim_delete'),

            'button_change'         => __('button_change'),
            'button_remove'         => __('button_remove'),
            'button_add'            => __('button_add'),
            'button_status'          => __('button_status'),
        );
        
        //извлечение пути
        $path = $this->request->param('path');
        
        $this->session->delete('path'); 
        if (isset($path)) {
            if ($path != '') {
                $this->path = explode('_', $path);
                $this->session->set('path', $path);
            } 
            else $this->session->delete('path'); 
        } 
        elseif($this->session->get('path')) $this->path = explode('_', $this->session->get('path'));
        

        $categories = $this->getCategories(0);

        //формируем значения для шаблона
        $content = View::factory($this->template_admin.'categories/v_categories_list')
            ->bind('template',$this->template_admin)
            ->bind('box_title',$this->template->page_title)
            ->bind('message', $this->message) 
            ->bind('errors', $this->errors)
            ->bind('categories', $categories)
            ->bind('text', $text);
        
        // Вывод в шаблон
        $this->template->block_center = array($content);
    }
    
    //добавление категории
    public function action_add() {
        
        //если нажата кнопка сохранить
        if (isset($_POST['action']) && $_POST['action'] == "add" && $this->validateModify())
        {
 
            $this->errors = array();
            
            //Извлечение данных
            $this->data = Arr::extract($_POST, array('alias', 'status', 'sort_order', 'category_description','parent_id', 'action', 'id','top', 'column', 'category'));
            $this->data['alias'] = $this->translateAlias($this->data['alias']);
            //загружаем модель
            $category = ORM::factory('Admin_Category');
            $category->date_modified = time();
            $category->values($this->data);
            
            //проверяем на валидацию категорию
            try {
                $category->check();
            }
            catch(ORM_Validation_Exception $e)
            {
                $this->errors = $e->errors('admin/'.$this->language_folder);
            }
            
            //проверяем на валидацию описание категории
            foreach ($this->data['category_description'] as $k=>$value) {
                $descriptions = ORM::factory('Admin_Categoriesdescription');
                $descriptions->values($this->data['category_description'][$k]);
                try {
                    $descriptions->check();
                }
                catch (ORM_Validation_Exception $e) {
                    $this->errors = $e->errors('admin/'.$this->language_folder);
                }  
            }
            
            //если все ок, то сохраняем
            if(empty($this->errors)){
                 
                    //если не выбран родитель, то создаем, иначе добавляем ребенка
                    if (!$this->data['category']) $category->make_root();
                    else $category->insert_as_last_child($this->data['category']);

                    //сохранение мультиязычного описания категории
                    foreach ($this->data['category_description'] as $k=>$value) {
                        $descriptions = ORM::factory('Admin_Categoriesdescription');
                        $descriptions->category_id = $category->pk();
                        $descriptions->language_id = $k;
                        $descriptions->values($this->data['category_description'][$k]);
                        $descriptions->save(); 
                    }
                    $this->session->set('message', __('message_add'));
                    $this->cache->delete('categories');
                    $this->cache->delete('wcategories');
                    HTTP::redirect('admin/categories/path/'.$this->session->get('path'));
            }
        }

        $content = $this->getContent();
        
        // Вывод в шаблон
        $this->template->page_title .= __('heading_title_add');
        $this->template->block_center = array($content);
    }
    
    //Редактирование категории
    public function action_edit() {
        //если нажата кнопка сохранить
        if (isset($_POST['action']) && $_POST['action'] == "edit" && $this->validateModify())
        { 
            
            //Извлечение данных
            $this->data = Arr::extract($_POST, array('alias', 'status', 'sort_order', 'category_description','parent_id', 'action', 'id','top', 'column', 'category'));
            $this->data['alias'] = $this->translateAlias($this->data['alias']);
            
            //загрузка модели категорий
            $category = ORM::factory('Admin_Category', $this->data['id']);
            $category->date_modified = time();
            $category->values($this->data);
           
            //1. проверка на валидацию вложенных категорий
            if(!Model_Admin_Category::cat_child($this->data['category'], $this->data['id']) && $this->data['category'] != $this->data['parent_id']) 
                    $this->errors[] = __('error_child');
            
            //2. проверка на валидацию настроек категории
            try { $category->check(); }
            catch(ORM_Validation_Exception $e) { $this->errors = $e->errors('admin/'.$this->language_folder);}
            
            //3. проверка на валидацию описания категории
            foreach ($this->data['category_description'] as $k=>$value) {
                $descriptions = ORM::factory('Admin_Categoriesdescription')->where('category_id', '=', $this->data['id'])->and_where('language_id', '=', $k)->find();
                $descriptions->values($this->data['category_description'][$k]);
                try { $descriptions->check(); }
                catch (ORM_Validation_Exception $e) { $this->errors = $e->errors('admin/'.$this->language_folder); }                 
            }
            
            //если все ок, то сохраняем
            if(empty($this->errors)){ 
                if($this->data['category'] == $this->data['parent_id']){
                    $category->save();
                }
                else{
                    
                    switch (Model_Admin_Category::cat_child($this->data['category'], $this->data['id'])){
                        case 1: //деревья разные
                            $category->delete();    //удаляем категорию и всех её потомков
                            $category = ORM::factory('Admin_Category', $this->data['id']);
                            $category->id = $this->data['id'];
                            $category->date_modified = time();
                            $category->values($this->data);
                            
                            //если не выбран родитель, то создаем корневую, иначе добавляем к потомкам
                            if (!$this->data['category']) $category->make_root();
                            else $category->insert_as_last_child($this->data['category']);
                            break;
                            
                        case 2: //деревья одинаковые, то перемещаем к потомкам или создаем корень
                            if (!$this->data['category']) $category->make_root();
                            else $category->move_to_last_child($this->data['category']);
                            break;
                    }
                }
                //сохранение мультиязычного описания категории
                foreach ($this->data['category_description'] as $k=>$value) {
                    //извлекаем новость и обновляем
                    $descriptions = ORM::factory('Admin_Categoriesdescription')->where('category_id', '=', $this->data['id'])->and_where('language_id', '=', $k)->find();
                    $descriptions->values($this->data['category_description'][$k])->update();
                }
                $this->session->set('message', __('message_edit'));
                $this->cache->delete('categories');
                $this->cache->delete('wcategories');
                HTTP::redirect('admin/categories'); 
                
            }   
        }

        //получаем контент
        $content = $this->getContent();
        
        // Вывод в шаблон
        $this->template->page_title .= __('heading_title_edit');
        $this->template->block_center = array($content);
    }
    
    //изменение статуса категории
    public function action_statusupdate(){
        if(!$this->validateModify()){
    		$this->session->set('errors', __('error_permission'));	
    	}
    	else{
            $id = (int) $this->request->param('id');
            $status = (int) $this->request->param('status');
            
            if($status == 0 || $status == 1){
                $category = DB::update('categories')
                        ->where('id', '=', $id)
                        ->set(array('status' => $status))->execute();
                $this->session->set('message', __('message_status'));
            }
        }
        $this->cache->delete('categories');
        $this->cache->delete('wcategories');
        HTTP::redirect('admin/categories');
    }
    
    //функция формирования данных для шаблона
    private function getContent(){

        $id = (int) $this->request->param('id');

        $languages = ORM::factory('Admin_Language')->order_by('sort_order','ASC')->find_all();
        $categories = ORM::factory('Admin_Categoriesdescription')->where("language_id","=",$this->language_id)->find_all();

        //формирование массива категорий
        $cats = array();
        $cats[] = __("text_no_parent");
        foreach ($categories as $cat){
            if($cat->category_id != $id)
                $cats[$cat->category_id] = $cat->title;
        }
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
            'text_parent'           => __('text_parent'),
            'text_top'              => __('text_top'),
            'text_top_tooltip'      => __('text_top_tooltip'),
            'text_column'           => __('text_column'),
            'text_column_tooltip'   => __('text_column_tooltip'),

            'button_save'   	    => __('button_save'),
            'button_abort'          => __('button_abort'),
        );
        
        //если post пустой и существует id  
        if(empty($this->data) && $id)
        {
            //извлечение описания
            $data = ORM::factory('Admin_Categoriesdescription')->where('category_id', '=', $id)->find_all();

            //формируем массив из описаний мультиязычный
            foreach ($languages as $language){
                foreach ($data as $desc){
                    if($language->id == $desc->language_id){
                        $category_description[$language->id] = Array(
                            'seo_title' => $desc->seo_title,
                            'meta_description' => $desc->meta_description,
                            'meta_keywords' => $desc->meta_keywords,
                            'title' => $desc->title,
                            'description' => $desc->description,
                        );    
                    }
                }
            }

            //извлечение настроек категорий
            $category_obj = ORM::factory('Admin_Category', $id);

            if( ! $category_obj->loaded())
            {
                throw new HTTP_Exception_404('category not found');
            }

            //формирование массива настроек категорий
            $this->data = Array(
                "id"                    => $category_obj->id,
                "alias"                 => $category_obj->alias,
                "sort_order"            => $category_obj->sort_order,
                "status"                => $category_obj->status,
                "parent_id"             => $category_obj->parent_id,
                "top"                   => $category_obj->top,
                "column"                => $category_obj->column,
                "action"                => 'edit',
                "category_description"  => $category_description,
                "categories"            => $cats,
            );
        }
        
        //если post не пустой 
        if(!empty($this->data))
        {
            $this->data['categories'] = $cats;
            //$this->data['parent_id'] = isset($this->data["category"]) ? $this->data["category"] : 0;
        }
        
        //если post пустой, и не существует id
        if(empty($this->data) && !$id){ 
            $this->data = array(
               "categories"             => $cats,
               "action"                 => "add",
               "id"                     => 0,
               "alias"                  => "",
               "sort_order"             => "",
               "status"                 => 0,
               "top"                    => 0,
               "column"                 => "",
               "parent_id"              => 0,
               
           ); 
        }

        $path = $this->session->get('path');
        //формируем весь контент
        $content = View::factory($this->template_admin.'categories/v_categories_form')
                ->bind('template',$this->template_admin)
                ->bind('box_title',$this->template->page_title)
                ->bind('errors', $this->errors) //ошибки
                ->bind('languages', $languages) //массив языков
                ->bind('locale', $this->language_folder)
                ->bind('text', $text) //массив текста для полей
                ->bind('path', $path)
                ->bind('data', $this->data);    //передаваемые данные
                          
        return $content;
    }
    
    //Удаление категории
    public function action_delete() {
        if(!$this->validateModify()){
            $this->session->set('errors', __('error_permission'));	
    	}
    	else{
            //Извлечение данных
            $selected = $this->request->post("selected");    
            if(isset($selected)){ 
                //перебираем все категории и удаляем
                foreach($selected as $delete_id){
                    if($delete_id != 0){ 
                        //создаем правило для проверки на удаление
                        $validation = Validation::factory(array("parent_id" => $delete_id));
                        $validation->rule('parent_id', 'Model_Admin_Category::cat_delete',  array(':value'))
                                   ->rule('parent_id', 'Model_Admin_Category::cat_article', array(':value'));
                        
                        //Проверяем категорию на удаление
                        if($validation->check()){
                            //удаляем категорию из всех таблиц
                            $category = ORM::factory('Admin_Category')->where("id", "=", $delete_id)->find();
                            $category->delete();
                            DB::delete('categoriesdescriptions')->where('category_id', '=', $delete_id)->execute();
                        }
                        else {
                            $this->errors = $validation->errors('admin/'.$this->language_folder."/admin_category");
                            $this->session->set('errors', $this->errors['parent_id']);
                            HTTP::redirect('admin/categories/path/'.$this->session->get('path'));
                        }
                    }
                }
                
                //если ошибок нет, то выводим сообщение что все гуд
                if(empty($this->errors)){ 
                    $this->session->set('message', __('message_delete'));
                }
            }
        }
        $this->cache->delete('categories');
        $this->cache->delete('wcategories');
        HTTP::redirect('admin/categories');
    }

    private function getCategories($parent_id, $parent_path = '', $indent = ''){
        $category_id = array_shift($this->path);
        
        $output = array();

        static $href_category = null;
        static $href_action = null;

        if ($href_category === null) {
                $href_category = "admin/categories/path/";
                $href_action = "admin/categories/edit/";
        }
        
        //извлекаем категории
        $results = DB::select()
            ->from('categories')   
            ->where('categoriesdescriptions.language_id', '=', $this->language_id)
            ->and_where('parent_id','=',$parent_id)    
            ->join('categoriesdescriptions')->on('categories.id', '=', 'categoriesdescriptions.category_id')
            ->order_by("categories.id", "ASC")
            ->execute()->as_array();
        
        
        
        foreach ($results as $result) {
                $path = $parent_path . $result['category_id'];
                $children = ORM::factory('Admin_Category',$result['category_id'])->count();
                
                $href = ($children) ? $href_category . $path : '';
                $name = $result['title'];

                if ($category_id == $result['category_id']) {
                        $name = '<b>' . $name . '</b>';
                        $this->template->page_url[] = HTML::anchor($href, $name);
                        $href = '';
                }

                $action = array(
                        'text' => __('button_change'),
                        'href' => $href_action . $result['category_id']
                );

                $output[$result['category_id']] = array(
                        'category_id'   => $result['category_id'],
                        'name'          => $name,
                        'sort_order'    => $result['sort_order'],
                        'action'        => $action,
                        'href'          => $href,
                        'indent'        => $indent,
                        'children'      => $children,
                        'status'        => $result['status'],
                        'date_modified' => $result['date_modified'],
                        'alias'         => $result['alias'],
                );
               
                if ($category_id == $result['category_id']) {
                        $output += $this->getCategories($result['category_id'], $path . '_', $indent . str_repeat('&nbsp;', 8));
                }
        }

        return $output; 
    }
}