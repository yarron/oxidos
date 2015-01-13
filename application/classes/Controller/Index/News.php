<?php defined('SYSPATH') or die('No direct script access.');
/*
 * Новости
 */
class Controller_Index_News extends Controller_Index {
    private $header;
    private $slider;
    private $content_top;  
    private $content_bottom;
    private $column_left;
    private $column_right;
    private $footer;
    private $page_url;
    private $text;
    
    public function  before() {
        parent::before();
        if($this->config->get('maintenance') && !$this->super) throw new HTTP_Exception_307('maintenance');
        if(BROWSER=="UPDATE") throw new HTTP_Exception_403();
        $route = array('route' => Request::current()->controller(), 'uri' => $this->request->uri());
        //инициализация шаблонов
        $this->header                     = Kohana_Widget::load('header', $route); 
        $this->slider                     = Kohana_Widget::load('slider', $route);
        $this->content_top                = Kohana_Widget::load('contenttop', $route);
        $this->content_bottom             = Kohana_Widget::load('contentbottom', $route);
        $this->column_left                = Kohana_Widget::load('columnleft', $route);                                    
        $this->column_right               = Kohana_Widget::load('columnright', $route);
        $this->footer                     = Kohana_Widget::load('footer');
        
        i18n::lang('index/'.$this->language_folder.'/index');
        $this->page_url = HTML::anchor('',__('text_home')). " &raquo; ";
        
        //загрузка языкового файла
        i18n::lang('index/'.$this->language_folder.'/news');
        
    }    
    public function action_index() {
        $alias = $this->request->param('alias');

        $this->text = array(
            'heading_title'         => __('heading_title'),
            'text_read_more'        => __('text_read_more'),
            'text_return'           => __('text_return'),
            'text_date'             => __('text_date'),
            'text_no'             => __('text_no'),
        );

        //если переменной алиас не существует                
        if($alias == "")
            $this->getList();
        else
            $this->getNews($alias);

    }

    //функция получения списка новостей
    private function getList(){
        $count = ORM::factory('Index_New')->where('status', '=', 1)->count_all();
        
        i18n::lang('index/'.$this->language_folder.'/index');
        
        //формируем пагинацию
        $pagination = Pagination::factory(array(
            'total_items' => $count,
            'items_per_page' => $this->config->get('count_new'),
        ))
            ->route_params( array(
                'controller' => Request::current()->controller(),
                'action' => Request::current()->action(),
        ));
        
        $news = DB::select()
                ->from('news')   
                ->join('newsdescriptions')->on('news.id', '=', 'newsdescriptions.new_id')
                ->where('newsdescriptions.language_id', '=', $this->language_id)
                ->and_where('news.status', '=', 1)
                ->limit($pagination->items_per_page)->offset($pagination->offset)
                ->order_by('date_modified', 'DESC')->as_object()->execute();
                
        if(empty($news)) 
            throw new HTTP_Exception_404();

        //ищем описания к найденным статьям
        foreach($news as $new){
            //формируем массив со статьей            
            $news_arr[$new->new_id] = array(
                'id'                => $new->new_id,
                'sort_order'        => $new->sort_order,
                'date_modified'     => $new->date_modified,
                'alias'             => $new->alias,
                'short'             => strip_tags($new->description,'<p><a><div><ul><ol><li><strong><span><u>'),
                'seo_title'         => $new->seo_title,
                'meta_description'  => $new->meta_description,
                'meta_keywords'     => $new->meta_keywords,
                'title'             => $new->title,
                'description'       => $new->description,
                'image'             => $new->image,
                'uri'               => 'news/'.$new->alias.'.html',
                'limit'             => $this->config->get('limit_new'),
                'width'            => $this->config->get('image_news'),
            );  
        }
       
        i18n::lang('index/'.$this->language_folder.'/news');    
        $this->template->title                      = __('heading_title');
        $this->template->description                = __('heading_title');
        $this->template->keywords                   = __('heading_title');
        $this->page_url .= HTML::anchor('news', $this->template->title);

        $content = View::factory($this->template_index.'news/v_news_list')
            ->bind('page_url',              $this->page_url)
            ->bind('news',                  $news_arr)
            ->bind('text',                  $this->text)
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
            header("Cache-Control: no-store, no-cache, must-revalidate");
        }
    }
    
     //функция получения новости по алиасу
    private function getNews($alias){
        $news = DB::select()
                ->from('news')   
                ->join('newsdescriptions')->on('news.id', '=', 'newsdescriptions.new_id')
                ->where('newsdescriptions.language_id', '=', $this->language_id)
                ->and_where('news.alias', '=', $alias)
                ->and_where('news.status', '=', 1)
                ->limit(1)->execute()->as_array();
        if(empty($news)) 
            throw new HTTP_Exception_404();
        //формируем массив из новостей       
        $news_arr= array(
            'id'                => $news[0]['new_id'],
            'sort_order'        => $news[0]['sort_order'],
            'date_modified'     => $news[0]['date_modified'],
            'alias'             => $news[0]['alias'],
            'seo_title'         => $news[0]['seo_title'],
            'meta_description'  => $news[0]['meta_description'],
            'meta_keywords'     => $news[0]['meta_keywords'],
            'title'             => $news[0]['title'],
            'description'       => $news[0]['description'],
        );  
        
        i18n::lang('index/'.$this->language_folder.'/news');        
        $this->template->title                      = $news[0]['seo_title'];
        $this->template->description                = $news[0]['meta_description'];
        $this->template->keywords                   = $news[0]['meta_keywords'];
        $this->page_url .= HTML::anchor('news', __('heading_title'))." &raquo; ".HTML::anchor('news/'.$alias.".html", $news[0]['title']);

        $content = View::factory($this->template_index.'news/v_news')
            ->bind('page_url',              $this->page_url)
            ->bind('news',                  $news_arr)
            ->bind('text',                  $this->text)
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
            header('Last-Modified: '.gmdate('D, d M Y H:i:s \G\M\T', $news[0]['date_modified']));
            header("Cache-Control: no-store, no-cache, must-revalidate");
        }
        
    }
}