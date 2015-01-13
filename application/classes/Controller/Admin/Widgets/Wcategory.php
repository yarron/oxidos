<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Widgets_Wcategory extends Controller_Admin_Widgets {
    
    public function before() {
        parent::before();
        
        //загрузка языкового файла
        i18n::lang('admin/'.$this->language_folder.'/widgets/wcategory');
       
        // Вывод в шаблон
        $this->template->page_title = __('heading_title');
        $this->template->page_url[] = HTML::anchor('admin/widgets/wcategory', $this->template->page_title);
    }
    
    //Вызывается по-умолчанию 
    public function action_index() {

        if(isset($_POST["wcategory"]) && $this->validateModify()){
            $this->saveEncode($_POST);                  //кодируем массив в строку и сохраняем
            $this->session->set('message', __('message_update'));     //сохраняем сообщение в сессию
            $this->cache->delete('wcategories');
            HTTP::redirect('admin/widgets/'); //переадресация
        }
        elseif($_SERVER["REQUEST_METHOD"]=="POST" && empty($_POST) && $this->validateModify()){
            $this->delete("wcategory"); 
            $this->session->set('message', __('message_update'));     //сохраняем сообщение в сессию
            $this->cache->delete('wcategories');
            HTTP::redirect('admin/widgets/'); //переадресация
        }
	    //текстовые переменные
        $text = array(
            
            'entry_layout'            => __('entry_layout'),
            'entry_position'          => __('entry_position'),
            
            'entry_status'            => __('entry_status'),
            'entry_sort_order'        => __('entry_sort_order'),
	    
            'text_content_top'        => __('text_content_top'),
            'text_content_bottom'     => __('text_content_bottom'),
            'text_column_left'        => __('text_column_left'),
            'text_column_right'       => __('text_column_right'),
            'text_slider'      	      => __('text_slider'),	

            'button_add'              => __('button_add'),
            'button_remove'           => __('button_remove'),
            'button_add_widget'       => __('button_add_widget'),
            'button_save'   	    => __('button_save'),
            'button_abort'          => __('button_abort'),
        );
        
    	//извлекаем виджет категорий, если есть
    	$widget = ORM::factory('Admin_Extension')->where("key","=","wcategory")->find();
    	if( ! $widget->loaded())
    	{
    		$widget = array();	
    	}
    	else{
    		$widget = $this->extractDecode($widget);      //декодируем строку обратно в массив
    	}

    	//извлекаем схемы
    	$layouts = ORM::factory('Admin_Layout')->find_all();
    	
    	//формируем значения для шаблона
        $content = View::factory($this->template_admin.'widgets/w_category')
            ->bind('box_title',$this->template->page_title)
            ->bind('errors', $this->errors) 
            ->bind('widgets', $widget) 
            ->bind('layouts', $layouts) 
            ->bind('text', $text);   

        
        // Вывод в шаблон
        $this->template->block_center = array($content);
    }

}
