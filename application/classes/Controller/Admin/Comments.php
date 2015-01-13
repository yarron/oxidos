<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Comments extends Controller_Admin {

   public function before() {
        parent::before();
        $this->template->styles[] = 'styles/admin/bower_components/jquery-ui/themes/south-street/jquery-ui.min.css';
        $this->template->styles[] = 'styles/admin/bower_components/font-awesome/css/font-awesome.min.css';
        $this->template->styles[] = 'styles/admin/bower_components/summernote/dist/summernote.css';

        $this->template->scripts[] = 'styles/admin/bower_components/jquery-ui/ui/minified/core.min.js';
        $this->template->scripts[] = 'styles/admin/bower_components/jquery-ui/ui/minified/datepicker.min.js';
        $this->template->scripts[] = 'styles/admin/bower_components/jquery-ui/ui/minified/widget.min.js';
        $this->template->scripts[] = 'styles/admin/bower_components/jquery-ui/ui/minified/position.min.js';
        $this->template->scripts[] = 'styles/admin/bower_components/jquery-ui/ui/minified/menu.min.js';
        $this->template->scripts[] = 'styles/admin/bower_components/jquery-ui/ui/minified/autocomplete.min.js';

        $this->template->scripts[] = 'styles/admin/bower_components/summernote/dist/summernote.min.js';
        $this->template->scripts[] = 'styles/admin/bower_components/summernote/lang/summernote-ru-RU.js';
        $this->template->scripts[] = 'styles/admin/bower_components/summernote/plugin/summernote-ext-video.js';
        $this->template->scripts[] = 'styles/admin/bower_components/summernote/plugin/summernote-ext-fontstyle.js';

        $this->template->scripts[] = 'styles/'.$this->template_admin.'javascript/common.js';
          //загрузка языкового файла
        i18n::lang('admin/'.$this->language_folder.'/comments');
       
        // Вывод в шаблон
        $this->template->page_title = __('heading_title');
        $this->template->page_url[] = HTML::anchor('admin/comments', $this->template->page_title);
    }
    
    //Вызывается по-умолчанию список языков
    public function action_index() {
        $this->message = $this->session->get("message");
        $this->session->set('message', null);
        $this->errors = $this->session->get("errors");
        $this->session->set('errors', null);

        $text = Array(
            'column_action'         => __('column_action'),
            'column_status'         => __('column_status'),
            'column_article'        => __('column_article'),
            'column_author'         => __('column_author'),
            'column_rating'         => __('column_rating'),
            'column_date_modified'  => __('column_date_modified'),
            'column_ip'  			=> __('column_ip'),
            'column_is_reg'  		=> __('column_is_reg'),
            'column_email'  		=> __('column_email'),

            'text_yes'  			=> __('text_yes'),
            'text_no'  				=> __('text_no'),

            'button_change'         => __('button_change'),
            'button_remove'         => __('button_remove'),
            'button_add'            => __('button_add'),
            'button_status'          => __('button_status'),

            'message_no'            => __('message_no'),
            'confim_delete'         => __('confim_delete'),
            
        );
        
        //извлечение параметров запроса
        $page = $this->request->param('page');
        $status = $this->request->param('status');
        $sort = (string) $this->request->param('sort');
        $type = (string) $this->request->param('type');
        
        if($sort == "article_id") $table = 'articlesdescriptions.';
        else $table = 'comments.';
        
        //установка значений для выборки из базы по-умолчанию
        if($page == "") $page = 1;
        if($status == "") $status = -1;
        if($sort == "") $sort = "id";
        if($type == "") $type = "desc";
        
        //извлекаем количество пользователей
        $count = ORM::factory('Admin_Comment')->count_all();
        i18n::lang('admin/'.$this->language_folder.'/common');
        //высчитываем пагинацию
        $pagination = Pagination::factory(array('total_items' => $count,'view'=>'pagination/admin'))
            ->route_params( array(
            'controller' => Request::current()->controller(),
            'action' => Request::current()->action(),
        ));

        
        //извлекаем 
        $comments  = DB::select('comments.id', 'articlesdescriptions.title', 'comments.author', 'comments.rating', 'comments.date_modified', 'comments.status','comments.is_reg','comments.ip','comments.email')
            ->from('comments')   
            ->join('articlesdescriptions')->on('comments.article_id', '=', 'articlesdescriptions.article_id')
            ->where('articlesdescriptions.language_id', '=', $this->language_id)
            ->limit($pagination->items_per_page)->offset($pagination->offset)
            ->order_by($table.$sort, $type)->as_object()->execute();
        
        
        //формируем значения для шаблона
        $content = View::factory($this->template_admin.'comments/v_comments_list')
            ->bind('template',$this->template_admin)
            ->bind('box_title',$this->template->page_title)
            ->bind('message', $this->message)
            ->bind('errors',  $this->errors) 
            ->bind('pagination', $pagination) 
            ->bind('page', $page)
            ->bind('sort', $sort)
            ->bind('comments', $comments)
            ->bind('type', $type)    
            ->bind('text', $text);
        
        // Вывод в шаблон
        $this->template->block_center = array($content);
    }
    
    public function action_edit() {
        //если нажата кнопка сохранить
        if (isset($_POST['action']) && $_POST['action'] == "edit" && $this->validateModify())
        { 
            //Извлечение данных
            $this->data = Arr::extract($_POST, array('id', 'text','author', 'date_modified', 'rating', 'article_id', 'action','status'));

            //загрузка модели
            $comment = ORM::factory('Admin_Comment', $this->data['id']);
            
            if($this->data['date_modified'] == "")
                $this->data['date_modified'] = date("Y-m-d H:i:s");

            $comment->values($this->data);
            //проверка на валидацию
            try {
                $comment->check();
            }
            catch(ORM_Validation_Exception $e)
            {
                $this->errors = $e->errors('admin/'.$this->language_folder);
            }

            //если все ок, то сохраняем
            if(empty($this->errors)){ 
                $comment->save();   //обновляем параметры 
                $this->session->set('message', __('message_edit'));
                HTTP::redirect('admin/comments'); 
            }  
            
        }

        //получаем контент
        $content = $this->getContent();
        
        // Вывод в шаблон
        $this->template->page_title .= __('heading_title_edit');
        $this->template->block_center = array($content);
    }
    
    //добавление статьи
    public function action_add() {
        
        //если нажата кнопка сохранить
        if (isset($_POST['action']) && $_POST['action'] == "add" && $this->validateModify())
        { 
            //Извлечение данных
            $this->data = Arr::extract($_POST, array('id', 'text','author', 'date_modified', 'rating', 'article_id', 'action','status'));

            //загрузка модели
            $comment = ORM::factory('Admin_Comment');
            
            if($this->data['date_modified'] == "")
                $this->data['date_modified'] = date("Y-m-d H:i:s");

            $comment->values($this->data);

            //проверка на валидацию
            try {
                $comment->check();
            }
            catch(ORM_Validation_Exception $e)
            {
                $this->errors = $e->errors('admin/'.$this->language_folder);
            }

            //если все ок, то сохраняем
            if(empty($this->errors)){ 
                $comment->save();   //обновляем параметры 
                $this->session->set('message', __('message_add'));
                HTTP::redirect('admin/comments'); 
            }  
            
        }

        $content = $this->getContent();
        
        // Вывод в шаблон
        $this->template->page_title .= __('heading_title_add');
        $this->template->block_center = array($content);
    }
    
    //изменение статуса 
    public function action_statusupdate(){
        if(!$this->validateModify()){
    		$this->session->set('errors', __('error_permission'));	
    	}
    	else{
            $id = (int) $this->request->param('id');
            $status = (int) $this->request->param('status');
            
            if($status == 0 || $status == 1){
                $comment = ORM::factory('Admin_Comment', $id);
                
                if( ! $comment->loaded())
                {
                        throw new HTTP_Exception_404('Status not found');
                }
    
                $comment->status = $status;
                $comment->save();
                $this->session->set('message', __('message_status'));
            }
        }
        HTTP::redirect('admin/comments');
    }
    
    //Удаление 
    public function action_delete() {
        if(!$this->validateModify()){
    		$this->session->set('errors', __('error_permission'));	
    	}
    	else{
            //Извлечение данных
            $selected = $this->request->post("selected");    
            if(isset($selected)){ 
                //перебираем все комментарии и удаляем
                foreach($selected as $id){
                    if($id != 0){ 
                        $comment = ORM::factory('Admin_Comment')->where('id', '=', $id)->find(); //извлекаем
                        $comment->delete();        //удаляем  из базы  
                    }
                }
                $this->session->set('message', __('message_delete'));
            }
        }
        HTTP::redirect('admin/comments');
    }
    
     //функция формирования данных для шаблона
    private function getContent(){
        $id = (int) $this->request->param('id');


        $text = array(
            'text_article'          => __('text_article'),
            'text_author'           => __('text_author'),
            'text_text'             => __('text_text'),
            'text_date_modified'    => __('text_date_modified'),
            'text_rating'           => __('text_rating'),
            'text_status'           => __('text_status'),
            'text_bad'              => __('text_bad'),
            'text_excellent'        => __('text_excellent'),

            'button_save'   	    => __('button_save'),
            'button_abort'          => __('button_abort'),
        );
        
        //если post пустой и существует id  
        if(empty($this->data) && $id)
        {
            //извлечение 
            $comment = ORM::factory('Admin_Comment', $id);

            //извлекаем мультиязычный список заголовков конкретного комментария
            $title_obj = $comment->article->descriptions->find_all();

            //ищем заголовок выбранного языка
            $title = ""; 
            foreach ($title_obj as $title_l){
                if($title_l->language_id == $this->language_id){
                    $title = $title_l->title;
                }
            }

            //формирование массива 
            $this->data = Array(
                "id"            => $comment->id,
                "article"       => $title,
                "article_id"    => $comment->article_id,
                "author"        => $comment->author,
                "text"          => $comment->text,
                "rating"        => $comment->rating,
                "date_modified" => $comment->date_modified,
                "status"        => $comment->status,
                "action"        => "edit",
            );
        }
        
        //если post пустой, и не существует id
        if(empty($this->data) && !$id){ 
           $this->data = array(
                "id"            => 0,
                "article"       => "",
                "author"        => "",
                "text"          => "",
                "rating"        => 0,
                "date_modified" => date("Y-m-d H:i:s"),
                "status"        => 0,
                "action"        => "edit",
                "article_id"    => 0,
           ); 
        }
        
        //формируем весь контент
        $content = View::factory($this->template_admin.'comments/v_comments_form')
                ->bind('template',$this->template_admin)
                ->bind('box_title',$this->template->page_title)
                ->bind('errors', $this->errors) //ошибки
                ->bind('locale', $this->language_folder)
                ->bind('comment', $comment) //массив комментария
                ->bind('text', $text) //массив текста для полей
                ->bind('data', $this->data);    //передаваемые данные
                          
        return $content;
    }
}