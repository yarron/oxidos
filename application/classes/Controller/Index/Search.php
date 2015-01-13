<?php defined('SYSPATH') or die('No direct script access.');
/*
 * Поиск
 */
class Controller_Index_Search extends Controller_Index {
    private $page_url;
    private $categories = array();
    private $header;
    private $slider;
    private $content_top;
    private $content_bottom;
    private $column_left;
    private $column_right;
    private $footer;
    private $mode_comment;
        
    public function  before() {
        parent::before();
        if($this->config->get('maintenance') && !$this->super) throw new HTTP_Exception_307('maintenance');
        if(BROWSER=="UPDATE") throw new HTTP_Exception_403();
        
        $this->mode_comment = $this->config->get('mode_comment'); //режим комментариев
        
        i18n::lang('index/'.$this->language_folder.'/index');
        $this->page_url = HTML::anchor('',__('text_home')). " &raquo; ";

        $route = array('route' => Request::current()->controller(), 'uri' => $this->request->uri(),'filter_name' => $this->request->param('filter_name'));
        
        $this->header                     = Kohana_Widget::load('header', $route); 
        $this->slider                     = Kohana_Widget::load('slider', $route);
        $this->content_top                = Kohana_Widget::load('contenttop', $route);
        $this->content_bottom             = Kohana_Widget::load('contentbottom', $route);
        $this->column_left                = Kohana_Widget::load('columnleft', $route);                                    
        $this->column_right               = Kohana_Widget::load('columnright', $route);
        $this->footer                     = Kohana_Widget::load('footer');


        // 3 уровня поиска категорий
        $categories_1 = Model_Index_Category::getCategories(0,'by_parent',$this->language_id);
        
        foreach ($categories_1 as $category_1) {
            $level_2_data = array();
            $categories_2 = Model_Index_Category::getCategories($category_1['category_id'], 'by_parent',$this->language_id);
            
            foreach ($categories_2 as $category_2) {
                $level_3_data = array();
                $categories_3 = Model_Index_Category::getCategories($category_2['category_id'], 'by_parent',$this->language_id);

                foreach ($categories_3 as $category_3) {
                        $level_3_data[] = array(
                                'category_id' => $category_3['category_id'],
                                'name'        => $category_3['title'],
                        );
                }

                $level_2_data[] = array(
                        'category_id' => $category_2['category_id'],	
                        'name'        => $category_2['title'],
                        'children'    => $level_3_data
                );					
            }

            $this->categories[] = array(
                    'category_id' => $category_1['category_id'],
                    'name'        => $category_1['title'],
                    'children'    => $level_2_data
            );
        }
       
    }  

    public function action_index() {
        
        //загрузка языкового файла
        i18n::lang('index/'.$this->language_folder.'/search');
        
        $filter_name            = (string)$this->request->param('filter_name');
	    $filter_category_id     = (int)$this->request->param('filter_category_id');
        $filter_description     = (bool) $this->request->param('filter_description');	
        $sort                   = (string) $this->request->param('sort');
        $type                   = (string) $this->request->param('type');
        $page                   = $this->request->param('page');
    
        $text = array(
            'heading_title'         => __('heading_title'),
            'text_criteria'         => __('text_criteria'),
            'text_category'         => __('text_category'),
            'text_sub_category'     => __('text_sub_category'),
            'text_description'      => __('text_description'),
            'text_empty'            => __('text_empty'),
            'text_search'           => __('text_search'),
            'text_rating'           => __('text_rating'),
            'text_read_more'        => __('text_read_more'),
            'text_comment_count'    => __('text_comment_count'),
            'text_viewed'           => __('text_viewed'),
            'text_author'           => __('text_author'),
            'text_date'             => __('text_date'),
            
            'entry_search'          => __('entry_search'),
            'button_search'         => __('button_search'),
        );
        
        $this->template->title                      = __('heading_title');
        $this->template->description                = __('heading_title');
        $this->template->keywords                   = __('heading_title');
        
        //формируем хлебные крошки
        $this->page_url .= HTML::anchor('search', $this->template->title);
        
        //установка значений для выборки из базы по-умолчанию
        if($sort == "title") $table = 'articlesdescriptions.';
        else $table = 'articles.';
        
        if($page == "") $page = 1;
        if($sort == "") $sort = "id";
        if($type == "") $type = "desc";
        
        if($filter_name) $f1='LIKE';
        else $f1='!=';
        
        if($filter_category_id) $f2='=';
        else  $f2='!=';

        if($filter_description)$column = "description"; 
        else $column = "title";
        
        //ищем статьи, если указан хотябы один параметр
        if($filter_name || $filter_category_id || $filter_description){
            //извлекаем количество статей   
            $count = count( DB::select('articles.id')
                    ->from('articles')
                    ->where('articlesdescriptions.'.$column, $f1, '%'.$filter_name.'%')
                    ->and_where('articles_categories.category_id', $f2, $filter_category_id)
                    ->and_where('articles.status', "=", 1)
                    ->and_where('articlesdescriptions.language_id', '=', $this->language_id)
                    ->join('articlesdescriptions')->on('articles.id', '=', 'articlesdescriptions.article_id')
                    ->join('articles_categories')->on('articles.id', '=', 'articles_categories.article_id')
                    ->execute()->as_array() );
            
            i18n::lang('admin/'.$this->language_folder.'/common');
            
            //формируем массив данных для пагинации
            $route_params = array(
                'controller'            => Request::current()->controller(), 
                'action'                => Request::current()->action(),
            );
            if($filter_name) $route_params['filter_name'] = $filter_name;
            if($filter_category_id) $route_params['filter_category_id'] = $filter_category_id;
            if($filter_description) $route_params['filter_description'] = $filter_description;
            
            //высчитываем пагинацию
            $pagination = Pagination::factory(array( 'total_items' => $count,'items_per_page' => $this->config->get('count_search') ))->route_params($route_params);
            
            //извлекаем статьи
            $results = DB::select()
                ->from('articles')
                ->where('articlesdescriptions.'.$column, $f1, '%'.$filter_name.'%')
                ->and_where('articles_categories.category_id', $f2, $filter_category_id)
                ->and_where('articles.status', "=", 1)
                ->and_where('articlesdescriptions.language_id', '=', $this->language_id)
                ->join('articlesdescriptions')->on('articles.id', '=', 'articlesdescriptions.article_id')
                ->join('articles_categories')->on('articles.id', '=', 'articles_categories.article_id')
                ->limit($pagination->items_per_page)->offset($pagination->offset)->order_by($table.$sort, $type)->as_object()->execute();
            
            $articles = array();
            foreach($results as $result){
                $comments = ORM::factory('Index_Comment')->where('article_id', '=',$result->article_id)->count_all();
                
                //ищем категории к каждой статье
                $categories = DB::select('categories.id','categoriesdescriptions.title','categories.alias')
                    ->from('categories') 
                    ->where('categories.status', '=', 1)
                    ->and_where('categoriesdescriptions.language_id', '=',$this->language_id)
                    ->and_where('articles_categories.article_id', '=',$result->article_id)
                    ->join('categoriesdescriptions')->on('categories.id', '=', 'categoriesdescriptions.category_id')
                    ->join('articles_categories')->on('articles_categories.category_id', '=', 'categoriesdescriptions.category_id')->execute()->as_array(); 

                $str_arr = array();
                foreach($categories as $cat){
                        $str_arr[] = HTML::anchor("c/".$cat['alias'].'/', $cat['title']);
                }
                $str_cat = implode(", ", $str_arr);
                $first_cat = "c/".$categories[0]['alias'].'/';
                
                $articles[$result->article_id] = array(
                    'id'                => $result->article_id,
                    'sort_order'        => $result->sort_order,
                    'date_modified'     => strtotime($result->date_modified),
                    'alias'             => $result->alias,
                    'viewed'            => $result->viewed,
                    'short'             => strip_tags($result->description,'<p><a><div><ul><ol><li><strong><span><u>'),
                    'seo_title'         => $result->seo_title,
                    'meta_description'  => $result->meta_description,
                    'meta_keywords'     => $result->meta_keywords,
                    'title'             => $result->title,
                    'description'       => $result->description,
                    'image'             => $result->image,
                    'rating'            => $result->rating,
                    'author'            => $result->author,
                    'categories'        => $str_cat,
                    'category'          => $first_cat,
                    'comments'          => $comments,
                    'limit'             => $this->config->get('limit_search'),
                    'width'             => $this->config->get('image_search'),
                
                );
            }
            
        }
       
        
        $content = View::factory($this->template_index.'search/v_search')
        ->bind('template',      $this->template_index)
            ->bind('text',                  $text)
            ->bind('articles',              $articles)
            ->bind('filter_name',           $filter_name)
            ->bind('filter_category_id',    $filter_category_id)
            ->bind('filter_description',    $filter_description)
            ->bind('pagination',            $pagination)
            ->bind('mode',                  $this->mode_comment)    
            ->bind('page_url',              $this->page_url) 
            ->bind('categories',            $this->categories)   
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
            header("Cache-Control: no-store, no-cache, must-revalidate");
        }
    }


}