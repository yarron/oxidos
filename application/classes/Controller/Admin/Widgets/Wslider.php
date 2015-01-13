<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Widgets_Wslider extends Controller_Admin_Widgets {
    public function before() {
        parent::before();
        
        //загрузка языкового файла
        i18n::lang('admin/'.$this->language_folder.'/widgets/wslider');
       
        // Вывод в шаблон
        $this->template->page_title = __('heading_title');
        $this->template->page_url[] = HTML::anchor('admin/widgets/wslider', $this->template->page_title);
    }
    
    //Вызывается по-умолчанию 
    public function action_index() {

        if(isset($_POST["wslider"])  && $this->validate($_POST["wslider"]) && $this->validateModify()){
            $this->saveEncode($_POST);                  //кодируем массив в строку и сохраняем
            $this->session->set('message', __('message_update'));     //сохраняем сообщение в сессию
            $this->cache->delete('wslider');
            HTTP::redirect('admin/widgets/'); //переадресация
        }
        elseif($_SERVER["REQUEST_METHOD"]=="POST" && empty($_POST) && $this->validateModify()){
            $this->delete("wslider"); 
            $this->session->set('message', __('message_update'));     //сохраняем сообщение в сессию
            $this->cache->delete('wslider');
            HTTP::redirect('admin/widgets/'); //переадресация
        }
	    //текстовые переменные
        $text = array(
            'entry_layout'            => __('entry_layout'),
            'entry_advert'            => __('entry_advert'),
            'entry_position'          => __('entry_position'),
            'entry_status'            => __('entry_status'),
            'entry_sort_order'        => __('entry_sort_order'),
            'entry_size'              => __('entry_size'),
            'entry_width'             => __('entry_width'),
            'entry_height'            => __('entry_height'),
	    
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
        
    	if(empty($this->data)){
            //извлекаем виджет , если есть
        	$widget = ORM::factory('Admin_Extension')->where("key","=","wslider")->find();
        	if( ! $widget->loaded())
        	{
        		$widget = array();	
        	}
        	else{
        		$widget = $this->extractDecode($widget);      //декодируем строку обратно в массив
        	}
        }
        else{
            $widget = $this->data;
        }

    	//извлекаем схемы
    	$layouts = ORM::factory('Admin_Layout')->find_all();
        
        //извлекаем рекламу
    	$adverts = ORM::factory('Admin_Advert')->find_all();
    	
    	//формируем значения для шаблона
        $content = View::factory($this->template_admin.'widgets/w_slider')
            ->bind('box_title',$this->template->page_title)
            ->bind('errors', $this->errors) 
            ->bind('widgets', $widget) 
            ->bind('layouts', $layouts) 
            ->bind('adverts', $adverts) 
            ->bind('text', $text);   

        
        // Вывод в шаблон
        $this->template->block_center = array($content);
    }

    private function validate($rows) {
		foreach($rows as $row){
            $post = Validation::factory($row);
           
            $post->rule('width', 'not_empty')->rule('width', 'digit'  )->rule('width', 'max_length', array(':value', '4'))->label('width' ,__('entry_width'))
                 ->rule('height', 'not_empty')->rule('height', 'digit'  )->rule('height', 'max_length', array(':value', '4'))->label('height' ,__('entry_height'));

            if (!$post->check())
            {
                $this->errors = $post->errors('admin/'.$this->language_folder.'/widget');
            }
		}
        
        if(empty($this->errors)) return true;
        else{
            $this->data = $rows;
            return false;
        }
	}
}
