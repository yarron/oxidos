<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Widgets extends Controller_Admin {

    public function before() {
        parent::before();
        
        //загрузка языкового файла
        i18n::lang('admin/'.$this->language_folder.'/widgets');
       
        // Вывод в шаблон
        $this->template->page_title = __('heading_title');
        $this->template->page_url[] = HTML::anchor('admin/widgets', $this->template->page_title);
        
    }
    
    //Вызывается по-умолчанию список модулей
    public function action_index() {
        $this->message = $this->session->get("message");
        $this->session->set('message', null);
        
        $widgets = array();
        $widgets_obj = ORM::factory('Admin_Extension')->where("group","=","widget")->find_all();
        
        foreach ($widgets_obj as $wid){
                $widgets[] = $wid->key;
        }
        
        //текстовые переменные
        $text = Array(
            'column_action'         => __('column_action'),
            'column_name'           => __('column_name'),
            'column_status'         => __('column_status'),
            'text_edit'             => __('text_edit'),
            'message_no'            => __('message_no'),
        );
    
        //извлекаем пути к виджетам				
	    $files = glob(APPPATH . 'classes/Controller/Admin/Widgets/*.php');

        //если виджеты есть, то формируем ссылки из названия виджетов
        if ($files) {
            foreach ($files as $file) {
                $widget = basename(UTF8::strtolower($file), '.php');
                
                if (!in_array(UTF8::strtolower($widget), $widgets))
                    $status = 0;
                else
                    $status = 1;
                
                //загружаем язык виджета и формируем ссылку
                i18n::lang('admin/'.$this->language_folder.'/widgets/'. $widget);   								
                $this->data['widgets'][] = array(
					'name'   => __('heading_title'),
					'action' => $widget,
                    'status' => $status,
				);
                //загружаем язык контроллера снова
                i18n::lang('admin/'.$this->language_folder.'/widgets');
			}
		}

       
        //формируем значения для шаблона
        $content = View::factory($this->template_admin.'widgets/v_widgets_list')
            ->bind('template',$this->template_admin)
            ->bind('box_title',$this->template->page_title)
            ->bind('message', $this->message)    
            ->bind('widgets', $this->data['widgets'])
            ->bind('text', $text);
        
        // Вывод в шаблон
        $this->template->block_center = array($content);
    }

    //сохранение данных виджета в базу	
    protected function saveEncode($data){ 
        
    	$key = key($data);	//извлекаем ключ из массива (название модуля)
    	$value = serialize($data[$key]);	//создаем строку из массива
    	
    	//проверяем, а есть ли запись в базе данных
    	$count = ORM::factory('Admin_Extension')->where("key","=",$key)->count_all();
    	
    	if($count == 0){
    		$widget = ORM::factory('Admin_Extension');	
    	}
    	else{
    		$widget = ORM::factory('Admin_Extension')->where("key","=",$key)->find();
    	}
    	$widget->group = "widget";
	    $widget->key = $key;
    	$widget->value = $value;
    	$widget->save();
        $this->cache->delete('extensions');
    }

    //извлечение данных виджета из базы
    protected function extractDecode($data){ 
	   return unserialize($data->value);
    }
    
    //удаление данных виджета из базы
    protected function delete($data){ 
	   $widget = ORM::factory('Admin_Extension')->where("key","=",$data)->find();
        if( $widget->loaded())
        {
        	$widget->delete();
        }
        $this->cache->delete('extensions');
    }

}
