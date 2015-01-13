<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Index_Widgets_Whtml extends Controller_Index {
   
    public $template;
    
    public function action_index() {
        //извлекаем данные для отображения виджета, т.е. виджет с настройками, позицией и сортировкой
        $widget = Kohana_Widget::$params;
        
        $arr_widgets = array();
        
        //формируем массив в зависимости от языка
        foreach($widget['title'] as $k=>$value){
            if($k == $this->language_id)
                $arr_widgets[$k]['heading_title'] = $value;
        }
        foreach($widget['description'] as $k=>$value){
            if($k == $this->language_id)
                $arr_widgets[$k]['description'] = $value;
        }

        $this->template = View::factory($this->template_index.'widgets/w_html')
            ->bind('data',          $arr_widgets);
    }
}
