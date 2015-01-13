<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Index_Errors extends Controller_Index {
    
    public $message;
    public $status;
    
    private $header;
    private $slider;
    private $content_top;  
    private $content_bottom;
    private $column_left;
    private $column_right;
    private $footer;
    private $page_url;
    private $text;

    public function before()
    {

        parent::before();
        $route = array('route' => Request::current()->controller(), 'uri' => $this->request->uri());    //инициализация контроллера
        
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

        // Получаем статус ошибки
        $this->status = (int) $this->request->action();

        // Получаем сообщение об ошибке
        if (Request::$initial != Request::$current)
        {
            $message = rawurldecode($this->request->param('message'));     
            if ($message) $this->message = $message;
        }
        else $this->request->action(404);
        $this->response->status($this->status);
    }
    
    
    
    public function action_404()
    {
        //загрузка языкового файла
        i18n::lang('index/'.$this->language_folder.'/errors');
        $this->page_url .= __('heading_404');
        
        $this->text = __('text_404');

        // Назначаем шаблон		
        $content = View::factory($this->template_index.'errors/v_errors')
            ->bind('text',                  $this->text)
            ->bind('status',                $this->status)
            ->bind('message',               $this->message)
            ->bind('page_url',              $this->page_url)
            ->bind('header',                $this->header)
            ->bind('slider',                $this->slider)   
            ->bind('content_top',           $this->content_top)    
            ->bind('content_bottom',        $this->content_bottom)
            ->bind('column_left',           $this->column_left)
            ->bind('column_right',          $this->column_right)
            ->bind('footer',                $this->footer);
        
        // Вывод в шаблон
        $this->template->content = $content;
        $this->template->title                      = __('heading_404');
        $this->template->description                = __('heading_404');
        $this->template->keywords                   = __('heading_404');      
    }

    public function action_503()
    {
        
        //загрузка языкового файла
        i18n::lang('index/'.$this->language_folder.'/errors');
        $this->page_url .= __('heading_503');
        
        $this->text = __('text_503');
        
        // Назначаем шаблон		
        $content = View::factory($this->template_index.'errors/v_errors')
            ->bind('text',                  $this->text)
            ->bind('status',                $this->status)
            ->bind('message',               $this->message)
            ->bind('page_url',              $this->page_url)
            ->bind('header',                $this->header)
            ->bind('slider',                $this->slider)   
            ->bind('content_top',           $this->content_top)    
            ->bind('content_bottom',        $this->content_bottom)
            ->bind('column_left',           $this->column_left)
            ->bind('column_right',          $this->column_right)
            ->bind('footer',                $this->footer);
        
        // Вывод в шаблон
        $this->template->content = $content;
        $this->template->title                      = __('heading_503');
        $this->template->description                = __('heading_503');
        $this->template->keywords                   = __('heading_503');      
    }

    public function action_500()
    {
       
        //загрузка языкового файла
        i18n::lang('index/'.$this->language_folder.'/errors');
        $this->page_url .= __('heading_500');
        
        $this->text = __('text_500');
        
        // Назначаем шаблон		
        $content = View::factory($this->template_index.'errors/v_errors')
            ->bind('text',                  $this->text)
            ->bind('status',                $this->status)
            ->bind('message',               $this->message)
            ->bind('page_url',              $this->page_url)
            ->bind('header',                $this->header)
            ->bind('slider',                $this->slider)   
            ->bind('content_top',           $this->content_top)    
            ->bind('content_bottom',        $this->content_bottom)
            ->bind('column_left',           $this->column_left)
            ->bind('column_right',          $this->column_right)
            ->bind('footer',                $this->footer);
        
        // Вывод в шаблон
        $this->template->content = $content;
        $this->template->title                      = __('heading_500');
        $this->template->description                = __('heading_500');
        $this->template->keywords                   = __('heading_500'); 
    }
    
    public function action_307()
    {
       
        //загрузка языкового файла
        i18n::lang('index/'.$this->language_folder.'/errors');
        $this->page_url .= __('heading_307');
        
        $this->text = $info = $this->config->get('maintenance_info');
        
        // Назначаем шаблон		
        $content = View::factory($this->template_index.'errors/v_maintenance')
            ->bind('text',                  $this->text)
            ->bind('status',                $this->status)
            ->bind('message',               $this->message)
            ->bind('page_url',              $this->page_url)
            ->bind('header',                $this->header)
            ->bind('slider',                $this->slider)   
            ->bind('content_top',           $this->content_top)    
            ->bind('content_bottom',        $this->content_bottom)
            ->bind('column_left',           $this->column_left)
            ->bind('column_right',          $this->column_right)
            ->bind('footer',                $this->footer);
        
        // Вывод в шаблон
        $this->template->content = $content;
        $this->template->title                      = __('heading_307');
        $this->template->description                = __('heading_307');
        $this->template->keywords                   = __('heading_307'); 
    }
    public function action_403()
    {
        //загрузка языкового файла
        i18n::lang('index/'.$this->language_folder.'/errors');
        $this->page_url .= __('heading_403');
        
        $this->text = array(
            'head' => __('text_403_head'),
            'end' => __('text_403_end'),
        );

        $browsers = array(
            'ie' => array(
                'name'  => 'Internet Explorer',
                'image' => HTTP_IMAGE.'old/ie.jpg',
                'url'   => 'http://windows.microsoft.com/ru-ru/internet-explorer/download-ie/',
            ),
            'mf' => array(
                'name'  => 'Mosilla Firefox',
                'image' => HTTP_IMAGE.'old/mf.jpg',
                'url'   => 'http://www.mozilla.org/ru/firefox/new/',
            ),
            'op' => array(
                'name'  => 'Opera',
                'image' => HTTP_IMAGE.'old/op.jpg',
                'url'   => 'http://www.opera.com/ru',
            ),
            'gc' => array(
                'name'  => 'Google Chrome',
                'image' => HTTP_IMAGE.'old/gc.jpg',
                'url'   => 'https://www.google.ru/intl/ru/chrome/browser/',
            ),
            'as' => array(
                'name'  => 'Safari',
                'image' => HTTP_IMAGE.'old/as.jpg',
                'url'   => 'http://support.apple.com/kb/DL1531?viewlocale=ru_RU',
            ),
        );
        
        // Назначаем шаблон		
        $content = View::factory($this->template_index.'errors/v_old')
            ->bind('text',                  $this->text)
            ->bind('browsers',              $browsers)
            ->bind('status',                $this->status)
            ->bind('message',               $this->message)
            ->bind('page_url',              $this->page_url)
            ->bind('footer',                $this->footer);
        
        // Вывод в шаблон
        $this->template->content = $content;
        $this->template->title                      = __('heading_403');
        $this->template->description                = __('heading_403');
        $this->template->keywords                   = __('heading_403'); 
    }
    
    

}