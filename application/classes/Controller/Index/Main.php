<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Index_Main extends Controller_Index {

    public function  before() {

        parent::before();
        
        if($this->config->get('maintenance') && !$this->super) throw new HTTP_Exception_307('maintenance');
        if(BROWSER=="UPDATE") throw new HTTP_Exception_403();
    }
    public function action_index() {
        
        $uri = array('uri' => $this->request->uri());    //инициализация контроллера

        $header                     = Kohana_Widget::load('header', $uri);
        $slider                     = Kohana_Widget::load('slider');
        $content_top                = Kohana_Widget::load('contenttop');
        $content_bottom             = Kohana_Widget::load('contentbottom');
        $column_left                = Kohana_Widget::load('columnleft');                       
        $column_right               = Kohana_Widget::load('columnright');
        $footer                     = Kohana_Widget::load('footer');

        $content = View::factory($this->template_index.'common/v_main')
            ->bind('header',        $header)
            ->bind('slider',        $slider)  
            ->bind('content_top',   $content_top)    
            ->bind('content_bottom',$content_bottom)
            ->bind('column_left',   $column_left)
            ->bind('column_right',  $column_right)
            ->bind('footer',        $footer);
        
        // Вывод в шаблон
        $this->template->content = $content;
    }
}
