<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Articles extends Controller_Admin {
    public function before() {
        parent::before();
        $this->template->styles[] = 'styles/admin/bower_components/jquery-ui/themes/south-street/jquery-ui.min.css';
        $this->template->styles[] = 'styles/admin/bower_components/font-awesome/css/font-awesome.min.css';
        $this->template->styles[] = 'styles/admin/bower_components/summernote/dist/summernote.css';

        $this->template->scripts[] = 'styles/admin/bower_components/jquery-ui/ui/minified/core.min.js';
        $this->template->scripts[] = 'styles/admin/bower_components/jquery-ui/ui/minified/datepicker.min.js';

        $this->template->scripts[] = 'styles/admin/bower_components/summernote/dist/summernote.min.js';
        $this->template->scripts[] = 'styles/admin/bower_components/summernote/lang/summernote-ru-RU.js';
        $this->template->scripts[] = 'styles/admin/bower_components/summernote/plugin/summernote-ext-video.js';
        $this->template->scripts[] = 'styles/admin/bower_components/summernote/plugin/summernote-ext-fontstyle.js';
        $this->template->scripts[] = 'styles/'.$this->template_admin.'javascript/common.js';
        //загрузка языкового файла
        i18n::lang('admin/'.$this->language_folder.'/articles');

        // Вывод в шаблон
        $this->template->page_title = __('heading_title');
        $this->template->page_url[] = HTML::anchor('admin/articles', $this->template->page_title);
    }

    //показ всех статей
    public function action_index() {
        $this->message = $this->session->get("message");
        $this->session->set('message', null);
        $this->errors = $this->session->get("errors");
        $this->session->set('errors', null);

        $text = Array(
            'column_action'         => __('column_action'),
            'column_status'         => __('column_status'),
            'column_showed'         => __('column_showed'),
            'column_sort_order'     => __('column_sort_order'),
            'column_date_modified'  => __('column_date_modified'),
            'column_alias'          => __('column_alias'),
            'column_title'          => __('column_title'),
            'message_no'            => __('message_no'),
            'confim_delete'         => __('confim_delete'),

            'button_change'         => __('button_change'),
            'button_filter'         => __('button_filter'),
            'button_remove'         => __('button_remove'),
            'button_add'            => __('button_add'),
            'button_status'          => __('button_status'),
        );
        
        //инициализация переменных для сортировки
        $page = $this->request->param('page');
        $status = $this->request->param('status');
        
        $sort = (string) $this->request->param('sort');
        $type = (string) $this->request->param('type');
        
        if($sort == "title") $table = 'articlesdescriptions.';
        else $table = 'articles.';
        
        //инициализация переменных для фильтра
        $filter_title = (string) $this->request->param('title');
        $filter_alias = (string) $this->request->param('alias');
        $filter_date = (string) $this->request->param('date');
        $filter_sort = $this->request->param('sort_order');
        $filter_status =  $this->request->param('fstatus');

        //установка значений для выборки из базы по-умолчанию
        if($page == "") $page = 1;
        if($status == "") $status = -1;
        if($sort == "") $sort = "id";
        if($type == "") $type = "desc";
        
        if($filter_title != "") $f1='LIKE';
        else $f1='!=';
        
        if($filter_alias != "") $f2='LIKE';
        else  $f2='!=';
        
        if($filter_date != "") $f3='LIKE';
        else $f3='!=';
        
        if($filter_sort != "") $f4='=';
        else $f4='!=';
        
        if($filter_status != "") $f5='=';
        else $f5='!=';
        
        //установка значения языка
        $language_id = $this->language_id;

        //извлекаем количество статей   
        $count = count( DB::select('articles.id')
                ->from('articles')
                ->where('articlesdescriptions.title', $f1, '%'.$filter_title.'%')
                ->and_where('articles.alias', $f2, '%'.$filter_alias.'%')
                ->and_where('articles.date_modified', $f3, '%'.$filter_date.'%')
                ->and_where('articles.sort_order', $f4, $filter_sort)
                ->and_where('articles.status', $f5, $filter_status)
                ->and_where('articlesdescriptions.language_id', '=', $language_id)
                ->join('articlesdescriptions')->on('articles.id', '=', 'articlesdescriptions.article_id')
                ->execute()->as_array() );
        
        i18n::lang('admin/'.$this->language_folder.'/common');
        //высчитываем пагинацию
        $pagination = Pagination::factory(array( 'total_items' => $count ,'view'=>'pagination/admin'))
                ->route_params( array( 
                    'controller' => Request::current()->controller(), 
                    'action' => Request::current()->action(),
                  ));
        
        //извлекаем статьи
        $articles = DB::select()
            ->from('articles')   
            ->where('articlesdescriptions.title', $f1, '%'.$filter_title.'%')
            ->and_where('articles.alias', $f2, '%'.$filter_alias.'%')
            ->and_where('articles.date_modified', $f3, '%'.$filter_date.'%')
            ->and_where('articles.sort_order', $f4, $filter_sort)
            ->and_where('articles.status', $f5, $filter_status)
            ->and_where('language_id', '=', $language_id)
            ->join('articlesdescriptions')->on('articles.id', '=', 'articlesdescriptions.article_id')
            ->limit($pagination->items_per_page)->offset($pagination->offset)->order_by($table.$sort, $type)->execute()->as_array();

        //формируем значения для шаблона
        $content = View::factory($this->template_admin.'articles/v_articles_list')
            ->bind('template',$this->template_admin)
            ->bind('box_title',$this->template->page_title)
            ->bind('message', $this->message)
	        ->bind('errors',  $this->errors)
            ->bind('pagination', $pagination)
            ->bind('articles', $articles)
            ->bind('sort', $sort)
            ->bind('type', $type)
            ->bind('page', $page)
            ->bind('text', $text);

        // Вывод в шаблон
        $this->template->block_center = array($content);
    }

    //добавление статьи
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
            $this->data = Arr::extract($_POST, array('image','popup','alias', 'status', 'sort_order', 'article_category', 'article_description','action', 'id', 'button','status_comment'));
            $this->data['alias'] = $this->translateAlias($this->data['alias']);
            
            //загружаем модель
            $article = ORM::factory('Admin_Article');
            $article->date_modified = date("Y-m-d H:i:s");
            $article->author = $this->user->username;
            $article->values($this->data);
            
            //проверяем на валидацию статью
            try {
                $article->check();
            }
            catch(ORM_Validation_Exception $e)
            {
                $this->errors = $e->errors('admin/'.$this->language_folder);
            }
            
            //проверяем на валидацию описание статьи
            foreach ($this->data['article_description'] as $k=>$value) {
                $descriptions = ORM::factory('Admin_Articlesdescription');
                $descriptions->values($this->data['article_description'][$k]);
                try {
                    $descriptions->check();
                }
                catch (ORM_Validation_Exception $e) {
                    $this->errors = $e->errors('admin/'.$this->language_folder);
                }  
            }
            
            //если все ок, то сохраняем
            if(empty($this->errors)){
                $article->save();
                
                //сохранение категорий статьи
                if(isset($this->data['article_category']))
                    $article->add('categories', $this->data['article_category']); 
                
                //сохранение мультиязычного описания статья
                foreach ($this->data['article_description'] as $k=>$value) {
                    $descriptions = ORM::factory('Admin_Articlesdescription');
                    $descriptions->article_id = $article->pk();
                    $descriptions->language_id = $k;
                    $descriptions->values($this->data['article_description'][$k]);
                    $descriptions->save(); 
                }
                $this->session->set('message', __('message_add'));

                if($this->data['button'] == 'apply')
                    HTTP::redirect('admin/articles/edit/'.$article->pk());
                else
                    HTTP::redirect('admin/articles');
            }      
        }
       
        $content = $this->getContent();
        
        // Вывод в шаблон
        $this->template->page_title .= __('heading_title_add');
        $this->template->block_center = array($content);


    }
    
    //изменение статьи
    public function action_edit() {
        $this->message = $this->session->get("message");
        $this->session->set('message', null);
        $this->errors = $this->session->get("errors");
        $this->session->set('errors', null);

        $page = $this->request->param('page');
        if($page == "") $page = 1;

        //если нажата кнопка сохранить
        if (isset($_POST['action']) && $_POST['action'] == "edit" && $this->validateModify())
        {
            //Извлечение данных
            $this->data = Arr::extract($_POST, array('image','popup','alias', 'status', 'sort_order', 'article_category', 'article_description', 'action', 'id', 'button','status_comment'));
            $this->data['alias'] = $this->translateAlias($this->data['alias']);
            
            //загрузка модели статей
            $article = ORM::factory('Admin_Article', $this->data['id']);
            $article->date_modified = date("Y-m-d H:i:s");
            $article->author = $this->user->username;
            $article->values($this->data);
            
            //проверка на валидацию статьи
            try {
                $article->check();
            }
            catch(ORM_Validation_Exception $e)
            {
                $this->errors = $e->errors('admin/'.$this->language_folder);
            }
            
            //проверка на валидацию описания статьи
            foreach ($this->data['article_description'] as $k=>$value) {
                //извлекаем статью
                $descriptions = ORM::factory('Admin_Articlesdescription')->where('article_id', '=', $this->data['id'])->and_where('language_id', '=', $k)
                        ->find();
                $descriptions->values($this->data['article_description'][$k]);
                try {
                    $descriptions->check();
                }
                catch (ORM_Validation_Exception $e) {
                    $this->errors = $e->errors('admin/'.$this->language_folder);
                }                 
            }

            //если все ок, то сохраняем
            if(empty($this->errors)){ 
                $article->save();   //обновляем параметры статьи
                $article->remove('categories'); //удаляем категории этой статьи
                if(isset($this->data['article_category']))
                    $article->add('categories', $this->data['article_category']); //сохранение категорий статьи
                
                //сохранение мультиязычного описания статья
                foreach ($this->data['article_description'] as $k=>$value) {
                    //извлекаем статью
                    $descriptions = ORM::factory('Admin_Articlesdescription')->where('article_id', '=', $this->data['id'])->and_where('language_id', '=', $k)
                            ->find();

                    //обновляем её
                    $descriptions->values($this->data['article_description'][$k])
                            ->update();
                }
                $this->session->set('message', __('message_edit'));

                if($this->data['button'] == 'apply')
                    HTTP::redirect('admin/articles/page/'.$page.'/edit/'.$this->data['id']);
                else
                    HTTP::redirect('admin/articles/page/'.$page);

            }   
        }

        //получаем контент
        $content = $this->getContent();
        
        // Вывод в шаблон
        $this->template->page_title .= __('heading_title_edit');
        $this->template->block_center = array($content);
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
    		    $article = ORM::factory('Admin_Article', $id);
    		    
    		    if( ! $article->loaded())
    		    {
    		            throw new HTTP_Exception_404('Status not found');
    		    }
    
    		    $article->status = $status;
    		    $article->save();
    		    $this->session->set('message', __('message_status'));
    		}
    	}

        HTTP::redirect('admin/articles');
    }
    
    //удаление статьи
    public function action_delete(){
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
    		            DB::delete('articlesdescriptions')->where('article_id', '=', $id)->execute();
    		            DB::delete('articles')->where('id', '=', $id)->execute();
    		            DB::delete('articles_categories')->where('article_id', '=', $id)->execute();       
    		        }
    		    }
    		    $this->session->set('message', __('message_delete'));  
    		}
    	}
	
        HTTP::redirect('admin/articles');
    }
    
    //функция формирования данных для шаблона
    private function getContent(){

        $article_category = Array();

        $id = (int) $this->request->param('id');
        $page = $this->request->param('page');
        if($page == "") $page = 1;

        //Получение категорий
        $categories = ORM::factory('Admin_Categoriesdescription')->where("language_id","=",$this->language_id)->find_all();
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
            'text_popup'            => __('text_popup'),
            'text_browse'           => __('text_browse'),
            'text_clear'            => __('text_clear'),
            'text_image_manager'    => __('text_image_manager'),
            'text_comment'          => __('text_comment'),
            
            'text_show_cat'         => __('text_show_cat'),
            'text_select_all'       => __('text_select_all'),
            'text_select_remove'    => __('text_select_remove'),

            'button_loading'   	    => __('button_loading'),
            'button_preview'        => __('button_preview'),
            'button_save'   	    => __('button_save'),
            'button_abort'          => __('button_abort'),
            'button_apply'          => __('button_apply'),

        );
        
        //формирование массива категорий
        $cats = array();
        foreach ($categories as $cat){
            $cats[$cat->category_id] = $cat->title;
        }
        
        //если post пустой и существует id  
        if(empty($this->data) && $id)
        {
            //извлечение описания
            $data = ORM::factory('Admin_Articlesdescription')->where('article_id', '=', $id)->find_all();
            //формируем массив из описаний мультиязычный
            foreach ($languages as $language){
                foreach ($data as $desc){
                    if($language->id == $desc->language_id){
                        $article_description[$language->id] = Array(
                            'seo_title' => $desc->seo_title,
                            'meta_description' => $desc->meta_description,
                            'meta_keywords' => $desc->meta_keywords,
                            'title' => $desc->title,
                            'description' => $desc->description,
                        );    
                    }
                }
            }

            //извлечение настроек статей
            $article_obj = ORM::factory('Admin_Article', $id);

            if( ! $article_obj->loaded())
            {
                throw new HTTP_Exception_404('article not found');
            }

            //формирование массива настроек статей
            if ($article_obj->image && file_exists(DIR_IMAGE . $article_obj->image)) {
                $image = $article_obj->image;
            } else {
                $image = 'no_image.jpg';
            }
            $article_arr = Array(
                "id"            => $article_obj->id,
                "alias"         => $article_obj->alias,
                "sort_order"    => $article_obj->sort_order,
                "status"        => $article_obj->status,
                "image"         => $image,
                "popup"         => $article_obj->popup,
                "status_comment"=> $article_obj->status_comment,
                "thumb"         => $this->resizer($image, 100, 100),
                "no_image"      => $this->resizer('no_image.jpg', 100, 100),
                "action"        => 'edit',
            );

            //извлекаем категории конкретной статьи
            $category_arr = $article_obj->as_array();
            $category_arr['cat'] = $article_obj->categories->find_all()->as_array();

            //формируем масссив выделенных категорий
            foreach ($category_arr['cat'] as $cat){
                $article_category[] = $cat->id;
            }

            $article = array(
                "article_description" => $article_description,
                "article_category" => $article_category, 
            );

            //склеиваем два массива
            $this->data = array_merge($article, $article_arr);
        }

        //если post не пустой
        if(!empty($this->data)){
           $this->data["thumb"] = $this->data['image'] ? $this->resizer($this->data['image'], 100, 100) : $this->resizer('no_image.jpg', 100, 100);
           $this->data["no_image"] = $this->resizer('no_image.jpg', 100, 100);
           $this->data['article_category'] = $this->data['article_category'] ? $this->data['article_category'] : array();
        }

        //если post пустой, и не существует id
        if(empty($this->data) && !$id){ 
           $this->data = array(
                "action" => "add",
                "article_category" => array(),
                "id"                 => 0,
                "alias"              => "",
                "image"              => 'no_image.jpg',
                "popup"              => 0,
                "status_comment"     => 1,
                "thumb"              => $this->resizer('no_image.jpg', 100, 100),
                "no_image"           => $this->resizer('no_image.jpg', 100, 100),
                "sort_order"         => "",
                "status"             =>0
           ); 
        }

        //формируем весь контент
        $content = View::factory($this->template_admin.'articles/v_articles_form')
                ->bind('template',$this->template_admin)
                ->bind('box_title',$this->template->page_title)
                ->bind('message', $this->message)
                ->bind('errors', $this->errors)
                ->bind('categories', $cats)
                ->bind('languages', $languages)
                ->bind('locale', $this->language_folder)
                ->bind('text', $text)
                ->bind('page', $page)
                ->bind('data', $this->data);
                          
        return $content;
    }

    public function action_autocomplete() {
		$json = array();
		$filter_title = $this->request->param('title');

		if (!isset($filter_title)) 
			$filter_title = '';

        //извлекаем статьи
        $results = DB::select('articlesdescriptions.article_id', 'articlesdescriptions.title')
            ->from('articlesdescriptions')   
            ->where('articlesdescriptions.title','LIKE', '%'.$filter_title.'%')
            ->and_where('language_id', '=', $this->language_id)
            ->limit(20)->execute()->as_array();
        
		foreach ($results as $result) {

			$json[] = array(
				'article_id'    => $result['article_id'],
				'title'         => html_entity_decode($result['title'], ENT_QUOTES, 'UTF-8'),	
			);	
		}

		echo (json_encode($json)); die();
	}
}
