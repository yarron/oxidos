<?php defined('SYSPATH') or die('No direct script access.');
/*
 * Новости
 */
class Controller_Index_Articles extends Controller_Index {
    private $header;
    private $slider;
    private $content_top;
    private $content_bottom;
    private $column_left;
    private $column_right;
    private $footer;
    private $page_url;
    private $cat;
    private $text;
    private $mode_comment;
    private $comment_moderation;
    private $comment_guest;
    
    public function  before() {
        parent::before();
        if($this->config->get('maintenance') && !$this->super) throw new HTTP_Exception_307('maintenance');
        if(BROWSER=="UPDATE") throw new HTTP_Exception_403();
        
        $this->cat = $this->request->param('category');
        $route = array('route' => Request::current()->controller(), 'category' => $this->cat, 'uri' => $this->request->uri() );    //инициализация контроллера
        
        $this->template->scripts[]        = 'styles/'.$this->template_index . 'javascript/jquery/ckeditor/ckeditor.js';
        $this->template->scripts[]        = 'styles/'.$this->template_index . 'javascript/jquery/ckeditor/config.js';
        
        //инициализация шаблонов
        $this->header                     = Kohana_Widget::load('header', $route); 
        $this->slider                     = Kohana_Widget::load('slider', $route);
        $this->content_top                = Kohana_Widget::load('contenttop', $route);
        $this->content_bottom             = Kohana_Widget::load('contentbottom', $route);
        $this->column_left                = Kohana_Widget::load('columnleft', $route);                                    
        $this->column_right               = Kohana_Widget::load('columnright', $route);
        $this->footer                     = Kohana_Widget::load('footer');
        
        i18n::lang('index/'.$this->language_folder.'/index');
        $this->page_url = HTML::anchor('',__('text_home'));
        
        //загрузка языкового файла
        i18n::lang('index/'.$this->language_folder.'/articles');
    }   
    
    public function action_index() {
        //инициализации искомой категории из запроса
        $alias = $this->request->param('alias');
        $this->mode_comment = $this->config->get('mode_comment'); //режим комментариев
        $this->comment_moderation = $this->config->get('comment_moderation'); //режим комментариев
        $this->comment_guest = $this->config->get('comment_guest'); //режим комментариев

        //массив текстовых переменных
        $this->text = array(
            'text_read_more'        => __('text_read_more'),
            'text_all'              => __('text_all'),
            'text_date'             => __('text_date'),
            'text_no'               => __('text_no'),
            'text_viewed'           => __('text_viewed'),
            'text_author'           => __('text_author'),
            'text_name'           	=> __('text_name'),
            'text_email'           	=> __('text_email'),
            'text_captcha'          => __('text_captcha'),
            'text_category'         => __('text_category'),
            'text_rating'           => __('text_rating'),
            'text_refine'           => __('text_refine'),
            'text_comment'          => __('text_comment'),
            'text_comments'         => __('text_comments'),
            'text_comment_add'      => __('text_comment_add'),
            'text_comment_edit'     => __('text_comment_edit'),
            'text_comment_remove'   => __('text_comment_remove'),
            'text_comment_count'    => __('text_comment_count'),

            'rating'                => __('rating'),
            'rating_bad'            => __('rating_bad'),
            'rating_good'           => __('rating_good'),

            'button_add'            => __('button_add'),
            'button_edit'           => __('button_edit'),
            'button_abort'          => __('button_abort'),

            'confirm_delete'        => __('confirm_delete'),
            'loading'               => __('loading'),
            'moderation'            => __('moderation'),
        );
        
        // находим искомую категорию
        $category = ORM::factory('Index_Category')->where('alias', '=', $this->cat)->and_where('status', '=', 1)->find();
        
        //если нашли, то идем дальше, иначе редирект
        if(!$category->loaded()){
            throw new HTTP_Exception_404();
        }
        
        //находим описание к найденной категории
        $category_description = $category->descriptions->where('language_id', '=', $this->language_id)->find();
        
        //если переменной алиас не существует                
        if($alias == "")
            $this->getList($category, $category_description);
        else
            $this->getArticle($category, $category_description, $alias);

    }

    //функция получения списка статей
    private function getList($category, $category_description){
        //ищем всех родителей для того, чтобы выяснить весь путь до корня
        $parents = ORM::factory('Index_Category',$category->id)->where('status', '=', 1)->get_parents(true,true);
        $desc_parents = ORM::factory('Index_Categoriesdescription')->where('language_id', '=',$this->language_id)->find_all();
        
        //составляем полный путь категорий до главной
        foreach($parents as $parent){
            foreach($desc_parents as $description){
                if($description->category_id == $parent->id){
                    $this->page_url .=  " &raquo; ".HTML::anchor('c/'.$parent->alias,$description->title);
                }
            }
        }

        $category_list_arr = DB::select('categories.id','categoriesdescriptions.title','categories.alias')
                ->from('categories') 
                ->where('categories.status', '=', 1)
                ->and_where('categoriesdescriptions.language_id', '=',$this->language_id)
                ->and_where('categories.parent_id', '=',$category->id)
                ->join('categoriesdescriptions')->on('categories.id', '=', 'categoriesdescriptions.category_id')
                ->order_by('categories.sort_order',"ASC")
                ->order_by('categories.id',"ASC")
                ->execute()->as_array(); 
        $category_list = array();
        foreach($category_list_arr as $value){
            $category_list[] = HTML::anchor("c/".$value['alias'].'/', $value['title']);
        }
        
        //Формируем пагинацию
        $count = $category->articles->where('status', '=', 1)->count_all();

        i18n::lang('index/'.$this->language_folder.'/index');
        
        
        //формируем пагинацию
        $pagination = Pagination::factory(array(
            'total_items'       => $count,
            'items_per_page'    => $this->config->get('count_article'),
        ))
            ->route_params( array(
                'controller'    => Request::current()->controller(),
                'action'        => Request::current()->action(),
                'category'      => $this->cat,
        ));

        //ищем все статьи искомой категории               
        $articles = $category->articles
                        ->where('status', '=', 1)->limit($pagination->items_per_page)->offset($pagination->offset)
						->order_by('sort_order', 'ASC')
                        ->order_by('date_modified', 'DESC')->find_all();

        //ищем описания к найденным статьям
        foreach($articles as $article){
            $description = $article->descriptions->where('article_id', '=',$article->id)->and_where('language_id', '=', $this->language_id)->find();
            $comments = $article->comments->where('article_id', '=',$article->id)->count_all();
            
            //ищем категрии к каждой статье
            $categories = DB::select('categories.id','categoriesdescriptions.title','categories.alias')
                ->from('categories') 
                ->where('categories.status', '=', 1)
                ->and_where('categoriesdescriptions.language_id', '=',$this->language_id)
                ->and_where('articles_categories.article_id', '=',$article->id)
                ->join('categoriesdescriptions')->on('categories.id', '=', 'categoriesdescriptions.category_id')
                ->join('articles_categories')->on('articles_categories.category_id', '=', 'categoriesdescriptions.category_id')->execute()->as_array(); 

            $str_arr = array();
            foreach($categories as $cat){
                    $str_arr[] = HTML::anchor("c/".$cat['alias'].'/', $cat['title']);
            }
            $str_cat = implode(", ", $str_arr);

            //формируем массив со статьей            
            $articles_arr[$article->id] = array(
                        'id'                => $article->id,
                        'sort_order'        => $article->sort_order,
                        'date_modified'     => strtotime($article->date_modified),
                        'alias'             => $article->alias,
                        'viewed'            => $article->viewed,
                        'short'             => strip_tags($description->description,'<p><a><div><ul><ol><li><strong><span><u>'),
                        'seo_title'         => $description->seo_title,
                        'meta_description'  => $description->meta_description,
                        'meta_keywords'     => $description->meta_keywords,
                        'title'             => $description->title,
                        'description'       => $description->description,
                        'image'             => $this->resizer($article->image, $this->config->get('image_article'), $this->config->get('image_article')),
                        'popup'             => $article->popup,
                        'rating'            => $article->rating,
                        'author'            => $article->author,
                        'categories'        => $str_cat,
                        'comments'          => $comments,
                        'limit'             => $this->config->get('limit_article'),
                        'image_popup'       => $this->resizer($article->image, $this->config->get('image_popup'), $this->config->get('image_popup')),
            );          
        }

        //инициализация переменных шаблона
        $this->template->title                      = $category_description->seo_title;
        $this->template->description                = $category_description->meta_description;
        $this->template->keywords                   = $category_description->meta_keywords;
        
        
        $uri = $this->request->uri(); //инициализация запроса (маршрут/категория)

        //формируем весь контент
        $content = View::factory($this->template_index.'articles/v_articles_list')
            ->bind('template',      $this->template_index)
            ->bind('page_url',              $this->page_url)
            ->bind('category_description',  $category_description)
            ->bind('articles',              $articles_arr)
            ->bind('categories',            $category_list)
            ->bind('text',                  $this->text)
            ->bind('uri',                   $uri)
            ->bind('mode',                  $this->mode_comment)    
            ->bind('pagination',            $pagination)
            ->bind('header',                $this->header)
            ->bind('slider',                $this->slider)   
            ->bind('content_top',           $this->content_top)    
            ->bind('content_bottom',        $this->content_bottom)
            ->bind('column_left',           $this->column_left)
            ->bind('column_right',          $this->column_right)
            ->bind('footer',                $this->footer);
        // Вывод в шаблон
        $this->template->content = $content;
        
        if (!headers_sent()) {
            header('Last-Modified: '.gmdate('D, d M Y H:i:s \G\M\T', $category->date_modified));
            header("Cache-Control: no-store, no-cache, must-revalidate");
        }
    }
    
    //функция получения статьи по алиасу
    private function getArticle($category, $category_description, $alias){
        //ищем всех родителей для того, чтобы выяснить весь путь до корня
        $parents = ORM::factory('Index_Category',$category->id)->where('status', '=', 1)->get_parents(true,true);
        $desc_parents = ORM::factory('Index_Categoriesdescription')->where('language_id', '=',$this->language_id)->find_all();

        //составляем полный путь категорий до главной
        foreach($parents as $parent){
            foreach($desc_parents as $description){
                if($description->category_id == $parent->id){
                    $this->page_url .=  " » ".HTML::anchor('c/'.$parent->alias,$description->title);
                }
            }
        }
        //ищем статью искомой категории  по алиасу
        $article = $category->articles->where('status', '=', 1)->and_where('alias', '=', $alias)->find();
        //если нашли, то идем дальше, иначе редирект
        if(!$article->loaded()){
            throw new HTTP_Exception_404();
        }
        //обновляем количество просмотров
        $article->viewed = $article->viewed+1;
        $article->update();

        //ищем описание статьи
        $description = $article->descriptions->where('article_id', '=',$article->id)->and_where('language_id', '=', $this->language_id)->find();

        //Формируем пагинацию
        $count = $article->comments->where('article_id', '=',$article->id)->count_all();

        i18n::lang('index/'.$this->language_folder.'/index');

        //формируем пагинацию
        $pagination = Pagination::factory(array(
            'total_items'       => $count,
            'items_per_page'    => $this->config['count_comment'],
        ))
            ->route_params( array(
                'controller'    => Request::current()->controller(),
                'action'        => Request::current()->action(),
                'category'      => Request::current()->param('category'),
                'alias'         => Request::current()->param('alias'),
                'href'          => "#comment",
            ));
        //ищем комментарии к статье
        $comments = $article->comments
            ->where('article_id', '=',$article->id)->order_by('date_modified', 'ASC')
            ->limit($pagination->items_per_page)->offset($pagination->offset)
            ->find_all();


        //извлекаем id авторов комментариев
        $user_id = array();
        foreach($comments as $comment){
            if($comment->user_id)
                $user_id[]= $comment->user_id;
        }
        $user_id = array_unique($user_id); //оставляем в массиве только уникальные значения

        $users = array();
        if(!empty($user_id)){
            //извлекаем самих автором найденных комментариев
            $users_obj = ORM::factory('Index_User')->where('id', 'IN', $user_id)->find_all();
            foreach($users_obj as $user){
                $users[$user->id] = array(
                    'ava'       => $user->ava,
                    'username'  => $user->username,
                    'name'      => $user->name,
                    'email'     => $user->email,
                );
            }
        }

        //ищем все связанные категории этой статьи
        $categories = DB::select('categories.id','categoriesdescriptions.title','categories.alias')
            ->from('categories')
            ->where('categories.status', '=', 1)
            ->and_where('categoriesdescriptions.language_id', '=',$this->language_id)
            ->and_where('articles_categories.article_id', '=',$article->id)
            ->join('categoriesdescriptions')->on('categories.id', '=', 'categoriesdescriptions.category_id')
            ->join('articles_categories')->on('articles_categories.category_id', '=', 'categoriesdescriptions.category_id')->execute()->as_array();

        $str_arr = array();
        foreach($categories as $category){
            $str_arr[] = HTML::anchor("c/".$category['alias'].'/', $category['title']);
        }
        $str_cat = implode(", ", $str_arr);

        //формируем массив со статьей
        $articles_arr = array(
            'id'                => $article->id,
            'sort_order'        => $article->sort_order,
            'date_modified'     => strtotime($article->date_modified),
            'alias'             => $article->alias,
            'viewed'            => $article->viewed,
            'seo_title'         => $description->seo_title,
            'meta_description'  => $description->meta_description,
            'meta_keywords'     => $description->meta_keywords,
            'title'             => $description->title,
            'description'       => $description->description,
            'image'             => $article->image,
            'rating'            => $article->rating,
            'status_comment'    => $article->status_comment,
            'author'            => $article->author,
            'categories'        => $str_cat,
        );

        //инициализация переменных шаблона
        $this->template->title                      = $description->seo_title;
        $this->template->description                = $description->meta_description;
        $this->template->keywords                   = $description->meta_keywords;

        $uri = "c/".$this->cat;
        $this->page_url .= " » " . HTML::anchor($uri."/".$alias.".html", $description->title  );

        $auth = $this->auth->logged_in();

        if($auth) $user = $this->user->id;
        else $user = 0;

        $captcha = Captcha::instance();
        //формируем весь контент
        $content = View::factory($this->template_index.'articles/v_articles')
            ->bind('template',      		$this->template_index)
            ->bind('page_url',              $this->page_url)
            ->bind('category_description',  $category_description)
            ->bind('article',               $articles_arr)
            ->bind('comments',              $comments)
            ->bind('users',                 $users)
            ->bind('user',                  $user)
            ->bind('captcha',               $captcha)
            ->bind('text',                  $this->text)
            ->bind('uri',                   $uri)
            ->bind('lang',                  $this->lang)
            ->bind('auth',                  $auth)
            ->bind('alias',                 $alias)
            ->bind('mode',                  $this->mode_comment)
            ->bind('moderation',            $this->comment_moderation)
            ->bind('guest',                 $this->comment_guest)
            ->bind('pagination',            $pagination)
            ->bind('header',                $this->header)
            ->bind('slider',                $this->slider)
            ->bind('content_top',           $this->content_top)
            ->bind('content_bottom',        $this->content_bottom)
            ->bind('column_left',           $this->column_left)
            ->bind('column_right',          $this->column_right)
            ->bind('footer',                $this->footer);
        // Вывод в шаблон
        $this->template->content = $content;
        
        if (!headers_sent()) {
            header('Last-Modified: '.gmdate('D, d M Y H:i:s \G\M\T', strtotime($article->date_modified)));
            header("Cache-Control: no-store, no-cache, must-revalidate");
        }
    }
     
    
}