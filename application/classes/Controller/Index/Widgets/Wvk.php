<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Index_Widgets_Wvk extends Controller_Index {
   
    public $template;
    
    public function action_index() {
        parent::$scripts[] = '/vk.com/js/api/openapi.js?105';
        
        static $widget = 0;
        //загрузка языкового файла
        i18n::lang('index/'.$this->language_folder.'/widgets/wvk');
        
        $text = array(
            'heading_title'           => __('heading_title'),
        );
        //извлекаем данные для отображения виджета, т.е. виджет с настройками, позицией и сортировкой
        $setting = Kohana_Widget::$params;
		$widget = $widget++;

        $this->template = View::factory($this->template_index.'widgets/w_vk')
            ->bind('setting',          $setting)
            ->bind('text',          $text)
            ->bind('widget',        $widget);

    }
}
